<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track after response is prepared, only on successful GET requests
        if ($request->isMethod('GET') && $response->getStatusCode() < 400) {
            $this->track($request);
        }

        return $response;
    }

    protected function track(Request $request): void
    {
        try {
            $path = $request->path();

            // Ignore admin routes, api, storage, telemetry, and static assets
            if (
                $request->is('admin*') ||
                $request->is('login') ||
                $request->is('logout') ||
                $request->is('storage*') ||
                $request->is('up') ||
                $request->is('sitemap.xml') ||
                $request->is('favicon.ico') ||
                $request->ajax()
            ) {
                return;
            }

            $userAgent = (string) $request->userAgent();
            $ip = (string) $request->ip();

            $isBot = $this->detectBot($userAgent);
            $deviceType = $this->detectDevice($userAgent, $isBot);
            $browser = $this->detectBrowser($userAgent);
            $os = $this->detectOs($userAgent);
            $referer = $request->header('referer');
            $refererHost = $this->parseRefererHost($referer, $request->getHost());

            $location = $this->resolveLocation($ip);

            // Avoid duplicate logging on rapid same-page refreshes within 30 seconds
            $sessionKey = 'tracked_' . md5($ip . $path . date('YmdH') . floor(date('i') / 2));
            if (Cache::has($sessionKey)) {
                return;
            }
            Cache::put($sessionKey, true, 60);

            VisitorLog::create([
                'ip_address' => Str::limit($ip, 45, ''),
                'page_url' => Str::limit($request->fullUrl(), 500, ''),
                'page_title' => $this->guessPageTitle($request),
                'route_name' => $request->route()?->getName(),
                'method' => 'GET',
                'referer' => $referer ? Str::limit($referer, 500, '') : null,
                'referer_host' => $refererHost,
                'device_type' => $deviceType,
                'browser' => $browser,
                'os' => $os,
                'country' => $location['country'] ?? null,
                'city' => $location['city'] ?? null,
                'user_agent' => Str::limit($userAgent, 500, ''),
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'is_bot' => $isBot,
            ]);
        } catch (\Throwable $e) {
            // Silently log and ignore to never disturb user browsing
            Log::debug('Visitor tracking error: ' . $e->getMessage());
        }
    }

    protected function detectBot(string $ua): bool
    {
        $botKeywords = [
            'bot', 'crawl', 'spider', 'slurp', 'facebookexternalhit',
            'whatsapp', 'telegrambot', 'twitterbot', 'applebot',
            'semrush', 'ahrefs', 'bingpreview', 'googlebot', 'yandex',
        ];

        $lowerUa = strtolower($ua);
        foreach ($botKeywords as $keyword) {
            if (str_contains($lowerUa, $keyword)) {
                return true;
            }
        }

        return false;
    }

    protected function detectDevice(string $ua, bool $isBot): string
    {
        if ($isBot) {
            return 'Bot / Crawler';
        }

        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            return 'Tablet';
        }

        if (preg_match('/(android|iphone|ipod|blackberry|iemobile|opera mini|mobile)/i', $ua)) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    protected function detectBrowser(string $ua): string
    {
        if (preg_match('/edg/i', $ua)) return 'Microsoft Edge';
        if (preg_match('/chrome|crios/i', $ua) && !preg_match('/opr|opera/i', $ua)) return 'Google Chrome';
        if (preg_match('/firefox|fxios/i', $ua)) return 'Mozilla Firefox';
        if (preg_match('/safari/i', $ua) && !preg_match('/chrome|crios/i', $ua)) return 'Apple Safari';
        if (preg_match('/opr|opera/i', $ua)) return 'Opera';
        if (preg_match('/msie|trident/i', $ua)) return 'Internet Explorer';

        return 'Browser';
    }

    protected function detectOs(string $ua): string
    {
        if (preg_match('/windows|win32|win64/i', $ua)) return 'Windows';
        if (preg_match('/android/i', $ua)) return 'Android';
        if (preg_match('/iphone|ipad|ipod/i', $ua)) return 'iOS';
        if (preg_match('/macintosh|mac os x/i', $ua)) return 'macOS';
        if (preg_match('/linux/i', $ua)) return 'Linux';

        return 'Other OS';
    }

    protected function parseRefererHost(?string $referer, string $currentHost): string
    {
        if (empty($referer)) {
            return 'Direct / None';
        }

        $host = parse_url($referer, PHP_URL_HOST);
        if (empty($host) || $host === $currentHost || str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
            return 'Direct / Internal';
        }

        $host = preg_replace('/^www\./', '', strtolower($host));

        if (str_contains($host, 'linkedin.')) return 'LinkedIn';
        if (str_contains($host, 'github.')) return 'GitHub';
        if (str_contains($host, 'google.')) return 'Google Search';
        if (str_contains($host, 'twitter.') || str_contains($host, 't.co') || str_contains($host, 'x.com')) return 'Twitter / X';
        if (str_contains($host, 'instagram.')) return 'Instagram';
        if (str_contains($host, 'facebook.') || str_contains($host, 'fb.com')) return 'Facebook';
        if (str_contains($host, 'youtube.')) return 'YouTube';
        if (str_contains($host, 'reddit.')) return 'Reddit';

        return $host;
    }

    protected function resolveLocation(string $ip): array
    {
        if (
            in_array($ip, ['127.0.0.1', '::1']) ||
            str_starts_with($ip, '192.168.') ||
            str_starts_with($ip, '10.')
        ) {
            return ['country' => 'Localhost / Local', 'city' => 'Development'];
        }

        return Cache::remember('ip_geo_' . md5($ip), 86400 * 7, function () use ($ip) {
            try {
                $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}?fields=status,country,city");
                if ($response->successful() && $response->json('status') === 'success') {
                    return [
                        'country' => $response->json('country'),
                        'city' => $response->json('city'),
                    ];
                }
            } catch (\Throwable) {
                // Ignore API timeouts
            }

            return ['country' => 'Unknown', 'city' => null];
        });
    }

    protected function guessPageTitle(Request $request): string
    {
        $path = trim($request->path(), '/');
        if (empty($path)) {
            return 'Homepage';
        }

        $segments = explode('/', $path);
        return Str::headline(end($segments));
    }
}

