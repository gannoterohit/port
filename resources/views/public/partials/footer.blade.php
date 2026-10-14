<footer class="bg-[#05080E] text-slate-300 pt-16 pb-10 mt-auto border-t border-slate-800/80">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div>
                <h3 class="text-xl font-bold text-white mb-3">{{ $websiteName ?? config('app.name') }}</h3>
                <p class="text-sm text-slate-400 leading-relaxed mb-6">{{ \App\Models\Setting::get('footer_description') ?: ($profile->intro ?? ($profile->biography ? strip_tags(Str::limit($profile->biography, 200)) : 'Full Stack Web Developer crafting scalable applications.')) }}</p>
                @if($profile)
                    <div class="flex space-x-4">
                        @if($profile->email)
                            <a href="mailto:{{ $profile->email }}" class="text-gray-400 hover:text-white" title="Email me">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </a>
                        @endif
                        @php
                            $socialPlatforms = [
                                'whatsapp'  => ['setting' => 'social_whatsapp',  'label' => 'WhatsApp',  'color' => 'fab'],
                                'github'    => ['setting' => 'social_github',    'label' => 'GitHub',    'color' => 'fab'],
                                'linkedin'  => ['setting' => 'social_linkedin',  'label' => 'LinkedIn',  'color' => 'fab'],
                                'twitter'   => ['setting' => 'social_twitter',   'label' => 'Twitter',   'color' => 'fab'],
                                'facebook'  => ['setting' => 'social_facebook',  'label' => 'Facebook',  'color' => 'fab'],
                                'youtube'   => ['setting' => 'social_youtube',   'label' => 'YouTube',   'color' => 'fab'],
                                'instagram' => ['setting' => 'social_instagram', 'label' => 'Instagram', 'color' => 'fab'],
                            ];
                        @endphp
                        @foreach($socialPlatforms as $platform => $data)
                            @php
                                $url = \App\Models\Setting::get($data['setting']) ?: ($profile->social_links[$platform] ?? ($platform === 'whatsapp' ? $profile->whatsapp_url : null));
                            @endphp
                            @if($url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors">
                                    <span class="sr-only">{{ $data['label'] }}</span>
                                    @if($platform === 'whatsapp')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    @elseif($platform === 'github')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
                                    @elseif($platform === 'linkedin')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.846-3.037-1.851 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    @elseif($platform === 'twitter')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.71-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z"/></svg>
                                    @elseif($platform === 'facebook')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0H1.325C.588 0 0 .588 0 1.326v21.348C0 23.41.588 24 1.326 24H12.82v-9.294H9.692V11.41h3.128V8.414c0-3.1 1.894-4.788 4.66-4.788 1.34 0 2.48.102 2.77.146v3.228l-1.88.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.296h-3.12V24h6.116C23.412 24 24 23.41 24 22.674V1.326C24 .588 23.412 0 22.675 0z"/></svg>
                                    @elseif($platform === 'youtube')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a2.974 2.974 0 00-2.09-2.103C19.505 3.546 12 3.546 12 3.546s-7.505 0-9.408.537A2.974 2.974 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a2.974 2.974 0 002.09 2.103C4.495 20.454 12 20.454 12 20.454s7.505 0 9.408-.537a2.974 2.974 0 002.09-2.103C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    @elseif($platform === 'instagram')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            @foreach($footerWidgets as $widget)
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">{{ $widget->title }}</h4>
                    <ul class="space-y-2">
                        @foreach($widget->links as $link)
                            <li>
                                <a href="{{ url($link->url) }}" target="{{ $link->target }}"
                                    class="text-sm text-gray-400 hover:text-white transition-colors">
                                    {{ $link->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            @if($orphanedFooterLinks->isNotEmpty())
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Links</h4>
                    <ul class="space-y-2">
                        @foreach($orphanedFooterLinks as $link)
                            <li>
                                <a href="{{ url($link->url) }}" target="{{ $link->target }}"
                                    class="text-sm text-gray-400 hover:text-white transition-colors">
                                    {{ $link->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="border-t border-slate-800/80 pt-6 text-center text-sm text-slate-500">
            <p>{{ \App\Models\Setting::get('copyright_text') ?: ('© ' . date('Y') . ' ' . ($websiteName ?? config('app.name')) . '. All rights reserved.') }}</p>
        </div>
    </div>
</footer>
