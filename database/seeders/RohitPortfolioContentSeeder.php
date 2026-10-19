<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\HomepageSetting;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Testimonial;
use App\Models\WorkProcess;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

/**
 * Updates admin-managed portfolio content for Rohit Gannote.
 * Safe to re-run: updates by key/slug, does not delete records.
 */
class RohitPortfolioContentSeeder extends Seeder
{
    public function run(): void
    {
        Setting::seedDefaults();

        $settings = [
            'website_name' => 'Rohit Gannote',
            'site_description' => 'Laravel Backend Developer — custom web apps, REST APIs, admin panels, and business systems.',
            'footer_description' => 'I build Laravel backends for admin panels, business workflows, REST APIs, and integrations — with maintainable code and clear communication.',
            'contact_email' => 'rohitgannote@gmail.com',
            'default_seo_title' => 'Rohit Gannote | Laravel Backend Developer',
            'default_seo_description' => 'Laravel backend developer for custom web apps, REST APIs, admin panels, MySQL optimization, and third-party integrations. Based in Indore, India — available for remote freelance work.',
            'years_experience' => '3+',
            'training_text' => '6 months backend engineering program',
            'specialization_text' => 'LARAVEL BACKEND & APIs',
            'terminal_status_text' => 'Available for Freelance & Remote Work',
            'terminal_sla_text' => '< 24 business hours',
            'about_highlight_1' => 'Laravel admin panels & business workflows',
            'about_highlight_2' => 'REST APIs & third-party integrations',
            'about_highlight_3' => 'MySQL design & query optimization',
            'typewriter_titles' => "Laravel Backend Developer\nREST APIs & Admin Panels\nMySQL & Database Optimization",
            'projects_completed_count' => '',
            'client_satisfaction_percentage' => '',
            'show_hero_stat_3' => '0',
            'stat_3_label' => 'Client Satisfaction',
            'social_github' => 'https://github.com/rohitgannote',
            'social_linkedin' => 'https://linkedin.com/in/rohitgannote',
            'social_twitter' => 'https://twitter.com/rohitgannote',
            'website_address' => 'Indore, MP, India',
            'show_custom_cursor' => '1',
        ];

        foreach ($settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        $profile = Profile::first();
        if ($profile) {
            $profile->update([
                'name' => 'Rohit Gannote',
                'title' => 'Laravel Backend Developer',
                'subtitle' => 'Laravel backends, REST APIs, admin panels, and MySQL — for business web applications',
                'intro' => 'I am Rohit Gannote, a Laravel backend developer with 3+ years of hands-on experience. I build admin panels, REST APIs, and database-driven business applications for teams that need dependable, maintainable software — not quick hacks.',
                'biography' => '<p>I am <strong>Rohit Gannote</strong>, a <strong>Laravel backend developer</strong> from <strong>Indore, India</strong>. I work with PHP, Laravel, MySQL, and Redis to turn business requirements into working software: dashboards, permissions, reports, integrations, and APIs.</p>'
                    .'<p><strong>What I build:</strong> custom Laravel web applications, internal admin panels, REST APIs for mobile or third-party apps, and improvements to existing Laravel codebases (performance, bugs, new modules). Typical domains include operations tools, inventory/order flows, user management, and payment or notification integrations.</p>'
                    .'<p><strong>Technical focus:</strong> clean MVC structure, validated requests, policies and roles, migrations and seeders, queue jobs for emails and heavy tasks, Sanctum or token auth for APIs, and MySQL indexes/query tuning when pages slow down.</p>'
                    .'<p><strong>Experience snapshot:</strong> Laravel backend developer at Commercial Tech (2023–present); backend developer at CodeCraft Labs (2022–2023); completed a focused 6-month backend engineering program in 2022.</p>'
                    .'<p><strong>Freelance &amp; collaboration:</strong> I take on part-time freelance and remote contract work alongside my professional role. I prefer clear written scope, milestone delivery, and honest timelines. If you have an idea, existing Laravel project, or API integration need, you can reach me via the contact form or email.</p>',
                'experience_text' => 'Commercial Tech — Laravel Backend Developer (2023–Present) · CodeCraft Labs — Backend Developer (2022–2023) · Backend engineering program (6 months, 2022)',
                'location' => 'Indore, MP, India',
                'location_visible' => true,
                'contact_email' => 'rohitgannote@gmail.com',
                'contact_whatsapp' => null,
                'resume_button_visible' => true,
                'social_links' => [
                    'github' => 'https://github.com/rohitgannote',
                    'linkedin' => 'https://linkedin.com/in/rohitgannote',
                    'twitter' => 'https://twitter.com/rohitgannote',
                    'website' => null,
                ],
            ]);
        }

        $home = HomepageSetting::first();
        if ($home) {
            $home->update([
                'hero_heading' => 'Laravel Backend Developer',
                'hero_title' => 'Custom Laravel apps, APIs, and admin panels for growing businesses',
                'hero_description' => 'I build and improve Laravel backends: database design, secure APIs, admin dashboards, queues, and integrations with payment and third-party services. Available for freelance projects and remote contract work.',
                'primary_cta_text' => 'Discuss Your Project',
                'primary_cta_url' => '#contact',
                'secondary_cta_text' => 'View My Projects',
                'secondary_cta_url' => '#projects',
                'contact_cta_heading' => 'Have a Laravel project or backend problem to solve?',
                'contact_cta_description' => 'Send a short brief — what you are building, your timeline, and whether you have existing code. I review every message personally and usually reply within 24 business hours.',
                'section_order' => ['hero', 'services', 'projects', 'about', 'work_process', 'skills', 'testimonials', 'contact_cta'],
            ]);
        }

        $services = [
            'custom-web-application-development' => [
                'description' => 'Custom Laravel web applications for day-to-day business operations: dashboards, user roles, CRUD workflows, reports, exports, and notification flows. I handle backend architecture, database design, and admin interfaces (Blade or API integration as your project needs).',
                'features' => [
                    'Custom business rules & workflows',
                    'Admin panels with role-based access',
                    'MySQL schema design & migrations',
                    'Automated tests for critical paths',
                ],
                'cta_text' => 'Request Estimate',
            ],
            'restful-api-engineering-integration' => [
                'description' => 'Design and build secure REST APIs with Laravel — authentication, validation, versioning, and documentation. I integrate payment gateways (Stripe, Razorpay), SMS/email providers, CRMs, and webhooks so your app talks cleanly to external systems.',
                'features' => [
                    'Sanctum / token-based auth',
                    'Webhooks (receive & dispatch)',
                    'Payment gateway integration',
                    'Rate limiting & API documentation',
                ],
                'cta_text' => 'Request Estimate',
            ],
            'database-optimization-mysql-performance' => [
                'description' => 'Fix slow pages and heavy reports by improving MySQL schemas, indexes, and queries. I add caching with Redis where it helps, review N+1 issues, and plan migrations when your data model needs to scale.',
                'features' => [
                    'Slow query analysis & indexing',
                    'Schema normalization & redesign',
                    'Redis caching where appropriate',
                    'Data migration & integrity checks',
                ],
                'cta_text' => 'Request Estimate',
            ],
            'devops-cloud-hosting-ci-cd' => [
                'description' => 'Deployment support for Laravel applications: environment setup, Nginx/Apache guidance, SSL, and basic CI/CD with GitHub Actions. Usually offered as part of a build, launch, or handover — not as a standalone ops retainer unless agreed in scope.',
                'features' => [
                    'Production deployment guidance',
                    'Linux server & Nginx basics',
                    'SSL & environment configuration',
                    'GitHub Actions for deploy pipelines',
                ],
                'is_featured' => false,
                'cta_text' => 'Request Estimate',
            ],
        ];

        foreach ($services as $slug => $data) {
            $service = Service::where('slug', $slug)->first();
            if (! $service) {
                continue;
            }
            $payload = [
                'description' => $data['description'],
                'features' => $data['features'],
                'cta_text' => $data['cta_text'],
            ];
            if (array_key_exists('is_featured', $data)) {
                $payload['is_featured'] = $data['is_featured'];
            }
            $service->update($payload);
        }

        Service::where('slug', 'custom-web-application-development')->update(['is_featured' => true]);
        Service::where('slug', 'restful-api-engineering-integration')->update(['is_featured' => true]);
        Service::where('slug', 'database-optimization-mysql-performance')->update(['is_featured' => true]);

        $projects = [
            'e-commerce-analytics-hub' => [
                'title' => 'Multi-Vendor E-Commerce Platform (Laravel)',
                'category' => 'E-Commerce',
                'role' => 'Lead Backend Developer (Laravel)',
                'architecture_label' => 'Laravel 11 · MySQL · Redis · REST',
                'description' => 'A Laravel-based multi-vendor commerce backend with vendor dashboards, order workflows, and sales reporting. Includes payment gateway hooks, invoice generation, and Redis-backed session handling for smoother checkout during busy periods.',
                'purpose' => 'Allow multiple sellers to operate on one platform with centralized orders, inventory, and reporting.',
                'key_features' => 'Vendor & admin dashboards | Order & inventory workflows | Payment gateway integration | PDF invoices & notifications | Redis-backed cart/session & queued jobs',
                'challenges' => 'Avoiding oversells during concurrent orders and keeping sales reports responsive as transaction volume grows.',
                'solutions' => 'Optimistic locking on inventory updates, indexed reporting queries, and Redis queues for aggregation and notifications.',
                'seo_title' => 'Multi-Vendor E-Commerce Platform (Laravel) - Rohit Gannote',
                'seo_description' => 'Laravel multi-vendor e-commerce backend with admin dashboards, payments, Redis queues, and sales reporting — case study by Rohit Gannote.',
            ],
            'taskflow-agile-workspace' => [
                'title' => 'Team Task & Kanban Workspace (Laravel)',
                'category' => 'Productivity',
                'role' => 'Backend Developer (Laravel)',
                'architecture_label' => 'Laravel · MySQL · REST · Alpine.js UI',
                'description' => 'Project management application with Kanban boards, tasks, roles, and activity tracking for small teams. Laravel powers permissions, business rules, notifications, and reporting; Alpine.js supports an interactive board UI.',
                'purpose' => 'Give teams a simple way to track tasks, sprints, and time without heavyweight tooling.',
                'key_features' => 'Kanban boards & task statuses | Role-based permissions | Time logs & work history | Webhook/Slack-style notifications | Sprint summary reports',
                'challenges' => 'Keeping board updates consistent when several users edit tasks at the same time.',
                'solutions' => 'Server-side validation, structured update endpoints, and event broadcasting for live board sync.',
                'seo_title' => 'Team Task & Kanban Workspace (Laravel) - Rohit Gannote',
                'seo_description' => 'Laravel task management backend with Kanban workflows, RBAC, and notifications — portfolio project by Rohit Gannote.',
            ],
            'nebula-cloud-api-gateway' => [
                'title' => 'API Gateway & Developer Portal (Laravel)',
                'category' => 'API Platform',
                'role' => 'Backend Developer — APIs & platform logic',
                'architecture_label' => 'Laravel 11 · Redis · MySQL · OpenAPI',
                'description' => 'API management portal for issuing keys, enforcing rate limits, tracking usage metrics, and publishing OpenAPI documentation. Built to give teams a single place to govern internal or partner-facing APIs.',
                'purpose' => 'Centralize API access control, observability, and developer documentation.',
                'key_features' => 'API key lifecycle | Rate limiting | Usage & latency metrics | Health checks | Interactive API docs',
                'challenges' => 'Recording high request volume without overloading the primary database.',
                'solutions' => 'Redis counters for rate limits and batched writes for analytics persistence.',
                'seo_title' => 'API Gateway & Developer Portal (Laravel) - Rohit Gannote',
                'seo_description' => 'Laravel API gateway with keys, rate limits, metrics, and OpenAPI docs — backend case study by Rohit Gannote.',
            ],
        ];

        foreach ($projects as $slug => $data) {
            Project::where('slug', $slug)->update($data);
        }

        $experiences = [
            1 => [
                'company' => 'Commercial Tech',
                'role' => 'Laravel Backend Developer',
                'period' => '2023 — Present',
                'badge_text' => 'Current',
                'description' => 'Build and maintain Laravel applications and internal APIs: database design, authentication and permissions, payment and webhook integrations, queue workers, and MySQL performance fixes on production workloads.',
            ],
            2 => [
                'company' => 'CodeCraft Labs',
                'role' => 'Backend Developer',
                'period' => '2022 — 2023',
                'badge_text' => 'Previous role',
                'description' => 'Designed relational schemas, wrote and optimized SQL queries, and implemented Sanctum-based API authentication. Reduced N+1 query issues and improved response times on admin and reporting modules.',
            ],
            3 => [
                'company' => 'Professional Training',
                'role' => 'Backend Engineering Program (6 months)',
                'period' => '2022',
                'badge_text' => 'Training',
                'description' => 'Full-time program covering OOP PHP, Laravel fundamentals, MVC patterns, PSR-12 standards, Git, database normalization, and web security basics.',
            ],
        ];

        foreach ($experiences as $id => $data) {
            Experience::where('id', $id)->update($data);
        }

        $categoryDescriptions = [
            'backend' => 'Server-side logic with Laravel: apps, APIs, auth, queues, and integrations.',
            'frontend' => 'Admin UI support with Blade, Alpine.js, and Tailwind — focused on functional dashboards, not marketing design.',
            'database' => 'MySQL modeling, migrations, indexes, and query tuning for reliable data layers.',
            'api' => 'REST design, documentation, webhooks, and third-party service integration.',
            'tools' => 'Version control, deployment, and day-to-day development tooling.',
        ];

        foreach ($categoryDescriptions as $slug => $description) {
            SkillCategory::where('slug', $slug)->update(['description' => $description]);
        }

        $skillDescriptions = [
            'Laravel' => 'Admin modules, service layers, queues, Sanctum auth, and API resources.',
            'PHP' => 'Modern PHP (8+) for business logic, validation, and maintainable backend code.',
            'Node.js' => 'Lightweight scripts and integrations where Node fits the stack.',
            'Python' => 'Utility scripts and automation when needed alongside PHP projects.',
            'JavaScript' => 'Frontend interaction for admin screens and API-driven UIs.',
            'Vue.js' => 'Component-based UI when a SPA or richer admin is required.',
            'React' => 'Familiar with React for API-backed interfaces when projects require it.',
            'Tailwind CSS' => 'Rapid, consistent styling for admin panels and internal tools.',
            'Alpine.js' => 'Light interactivity in Blade views without a heavy JS framework.',
            'MySQL' => 'Schema design, migrations, indexes, and production query tuning.',
            'PostgreSQL' => 'Relational modeling and queries when PostgreSQL is the chosen database.',
            'Git' => 'Feature branches, reviews, and safe collaboration on Laravel codebases.',
            'Docker' => 'Local and staging environments for consistent Laravel development.',
            'AWS' => 'Basic cloud deployment patterns for Laravel apps when clients use AWS.',
        ];

        foreach ($skillDescriptions as $name => $description) {
            Skill::where('name', $name)->update(['description' => $description]);
        }

        WorkProcess::where('title', 'Agile Development')->update([
            'description' => 'Implement Laravel features and API endpoints in focused milestones, with demos and code review along the way.',
        ]);

        Testimonial::query()->update(['is_published' => false]);

        Cache::forget('profile');
        Cache::forget('homepage_settings');
        Cache::forget('public_settings_cache');
        Cache::forget('homepage_featured_projects');
        Cache::forget('homepage_featured_services');
        Cache::forget('homepage_skills');
        Cache::forget('homepage_skill_categories');
        Cache::forget('homepage_experiences');
        Cache::forget('homepage_testimonials');
        Cache::forget('homepage_work_processes');
        Cache::forget('contact_services');
    }
}
