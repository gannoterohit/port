<?php

namespace Database\Seeders;

use App\Models\HomepageSetting;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\WorkProcess;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PopulateRichDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Settings
        Setting::set('website_name', 'Rohit Gannote');
        Setting::set('site_description', 'Full Stack Web Developer | Laravel & MySQL Specialist');
        Setting::set('years_experience', '2.5+');
        Setting::set('training_text', '+ 6 Months Intensive Training');
        Setting::set('specialization_text', 'Laravel & MySQL Specialist');
        Setting::set('available_for_freelance', '1');
        Setting::set('primary_color', '#10B981'); // Modern Emerald
        Setting::set('secondary_color', '#059669');

        // 2. Profile
        $profile = Profile::first();
        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = 1;
        }

        $profile->name = 'Rohit Gannote';
        $profile->title = 'Full Stack Web Developer';
        $profile->subtitle = 'Laravel, PHP & MySQL Specialist — High Performance Web Applications';
        $profile->intro = 'Full Stack Developer with 2.5+ years of commercial software engineering experience and 6 months of comprehensive training. I specialize in designing scalable database architectures, high-performance RESTful APIs, and custom enterprise web applications.';
        $profile->biography = '<p>Hello, I\'m <strong>Rohit Gannote</strong>, a passionate Full Stack Software Developer specialized in the <strong>Laravel, PHP, and MySQL</strong> ecosystem.</p><p>Over the last 2.5+ years, I have engineered end-to-end web applications, e-commerce platforms, and admin dashboards. I focus on clean MVC architecture, fast MySQL database indexing and queries, secure authentication, and seamless user experiences with modern frontends.</p><p>Whether building an application from scratch or optimizing legacy codebases, I take pride in delivering clean, maintainable, and high-performance solutions.</p>';
        $profile->experience_text = 'Full Stack Developer at Tech Innovations (2022 - Present) | Backend Engineer at CodeCraft Labs (2021 - 2022) | 6 Months Intensive PHP & System Architecture Training';
        $profile->profile_photo = 'profile/avatar.jpg';
        $profile->resume_button_visible = true;
        $profile->location = 'Indore, MP, India';
        $profile->location_visible = true;
        $profile->contact_email = 'rohitgannote@gmail.com';
        $profile->contact_phone = '+91 98765 43210';
        $profile->contact_whatsapp = '+919876543210';
        $profile->social_links = [
            'github' => 'https://github.com/rohitgannote',
            'linkedin' => 'https://linkedin.com/in/rohitgannote',
            'twitter' => 'https://twitter.com/rohitgannote',
        ];
        $profile->save();

        // 3. HomepageSetting
        $homeSetting = HomepageSetting::first() ?? new HomepageSetting();
        $homeSetting->hero_heading = 'Full Stack Web Developer';
        $homeSetting->hero_title = 'Architecting High-Performance Web Applications & REST APIs';
        $homeSetting->hero_description = 'Crafting robust, scalable web applications using Laravel 11, PHP 8, and MySQL. From high-throughput APIs to complex admin portals and bespoke SaaS platforms.';
        $homeSetting->primary_cta_text = 'Hire Me';
        $homeSetting->primary_cta_url = '/contact';
        $homeSetting->secondary_cta_text = 'View My Projects';
        $homeSetting->secondary_cta_url = '/projects';
        $homeSetting->hero_section_enabled = true;
        $homeSetting->about_section_enabled = true;
        $homeSetting->skills_section_enabled = true;
        $homeSetting->projects_section_enabled = true;
        $homeSetting->services_section_enabled = true;
        $homeSetting->work_process_section_enabled = true;
        $homeSetting->testimonials_section_enabled = false;
        $homeSetting->contact_cta_section_enabled = true;
        $homeSetting->contact_cta_heading = 'Ready to Build Something Exceptional?';
        $homeSetting->contact_cta_description = 'Let\'s collaborate on your next web application. I am available for freelance projects, custom enterprise software development, and technical consulting.';
        $homeSetting->section_order = json_encode(['hero', 'about', 'skills', 'projects', 'services', 'work_process', 'testimonials', 'contact_cta']);
        $homeSetting->save();

        // 4. Projects with rich details and thumbnails
        $projects = [
            [
                'title' => 'E-Commerce Analytics & Multi-Vendor Hub',
                'slug' => 'e-commerce-analytics-hub',
                'description' => 'A full-featured multi-vendor e-commerce platform and live analytics dashboard engineered with Laravel 11, MySQL, and Tailwind CSS. Features real-time order tracking, Redis-powered cart sessions, automated invoice generation, payment gateway integration, and deep sales conversion metrics.',
                'category' => 'E-Commerce & SaaS',
                'thumbnail' => 'projects/ecommerce.jpg',
                'thumbnail_alt' => 'E-Commerce Analytics Dashboard',
                'tech_stack' => ['Laravel 11', 'PHP 8.3', 'MySQL', 'Tailwind CSS', 'Redis', 'Chart.js'],
                'purpose' => 'Streamline multi-store retail sales operations and real-time inventory synchronization.',
                'key_features' => "Real-Time Sales & Revenue Analytics | Stripe & Razorpay Payment Integrations | Automated Invoice PDF Generation | Multi-Store Inventory Management | Redis-Backed Cart Synchronization",
                'role' => 'Full Stack Lead Developer',
                'challenges' => 'Preventing overselling during flash-sale concurrency and maintaining low latency for report aggregation.',
                'solutions' => 'Implemented MySQL row-level optimistic locking and scheduled Redis background queue aggregation.',
                'demo_url' => null,
                'github_url' => 'https://github.com/rohitgannote/laravel-ecommerce-platform',
                'is_featured' => true,
                'status' => 'published',
                'display_order' => 1,
            ],
            [
                'title' => 'TaskFlow - Agile Team Workspace & Kanban',
                'slug' => 'taskflow-agile-workspace',
                'description' => 'A collaborative project management application with interactive Kanban boards, sprint burn-down charts, and team time tracking. Built with Laravel, Alpine.js, and MySQL to support high-velocity development squads.',
                'category' => 'Productivity & SaaS',
                'thumbnail' => 'projects/taskflow.jpg',
                'thumbnail_alt' => 'TaskFlow Kanban Project Board',
                'tech_stack' => ['Laravel', 'Alpine.js', 'MySQL', 'Tailwind CSS', 'WebSockets'],
                'purpose' => 'Provide a clean, friction-free project tracking suite for fast-moving engineering teams.',
                'key_features' => "Interactive Drag-and-Drop Kanban Boards | Time Tracking & Work Logs | Granular RBAC Permissions | Automated Slack & Webhook Notifications | Sprint Burndown Reports",
                'role' => 'Full Stack Developer',
                'challenges' => 'Ensuring instant board responsiveness without race conditions between team members.',
                'solutions' => 'Optimistic UI state updates coupled with real-time websocket broadcast validation.',
                'demo_url' => null,
                'github_url' => 'https://github.com/rohitgannote/taskflow-agile-workspace',
                'is_featured' => true,
                'status' => 'published',
                'display_order' => 2,
            ],
            [
                'title' => 'Nebula Cloud API Gateway & Dev Portal',
                'slug' => 'nebula-cloud-api-gateway',
                'description' => 'A centralized cloud API management portal providing token rate-limiting, latency metrics, endpoint health telemetry, and developer OpenAPI documentation. Engineered for high reliability and throughput.',
                'category' => 'Cloud & DevTools',
                'thumbnail' => 'projects/nebula_api.jpg',
                'thumbnail_alt' => 'Nebula API Gateway Dashboard',
                'tech_stack' => ['Laravel 11', 'REST APIs', 'MySQL', 'Redis', 'Docker'],
                'purpose' => 'Deliver secure API governance and microservices monitoring for developer ecosystems.',
                'key_features' => "Token Bucket Rate Limiting | Real-Time Latency Telemetry | Automated API Key Generation | Endpoint Health Probing | OpenAPI/Swagger Interactive Docs",
                'role' => 'Backend Specialist',
                'challenges' => 'Tracking thousands of requests per second without database bottlenecks.',
                'solutions' => 'Utilized Redis sliding-window counters and batched asynchronous persistence.',
                'demo_url' => null,
                'github_url' => 'https://github.com/rohitgannote/nebula-api-gateway',
                'is_featured' => true,
                'status' => 'published',
                'display_order' => 3,
            ],
        ];

        // Clear existing and replace cleanly
        Project::truncate();
        foreach ($projects as $p) {
            Project::create(array_merge($p, [
                'published_at' => now(),
                'seo_title' => $p['title'] . ' - Rohit Gannote',
                'seo_description' => Str::limit($p['description'], 155),
            ]));
        }

        // 5. Services: Ensure all 4 are featured and published
        Service::truncate();
        $services = [
            [
                'name' => 'Custom Web Application Development',
                'slug' => 'custom-web-application-development',
                'description' => 'End-to-end development of bespoke web applications tailored to your business operations. Built on Laravel and modern frontend technologies with a strong emphasis on security, scalability, and maintainability.',
                'features' => ['Tailored Business Logic', 'Database Schema Design', 'Role-Based Access Control (RBAC)', 'Comprehensive Automated Testing'],
                'is_featured' => true,
                'is_enabled' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'RESTful API Engineering & Integration',
                'slug' => 'restful-api-engineering-integration',
                'description' => 'Architecture and implementation of robust, secure RESTful APIs. Seamless third-party integrations including payment processors (Stripe, Razorpay, PayPal), CRM systems, and SMS/Email notification gateways.',
                'features' => ['JWT & Sanctum Auth', 'Webhook Receivers & Dispatchers', 'Third-Party Payment Gateways', 'API Rate Limiting & Documentation'],
                'is_featured' => true,
                'is_enabled' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Database Optimization & MySQL Performance',
                'slug' => 'database-optimization-mysql-performance',
                'description' => 'Query optimization, schema redesign, and index tuning to eliminate database bottlenecks. Implementing Redis caching layers and read-replicas for high-traffic environments.',
                'features' => ['Slow Query Analysis & Indexing', 'Schema Normalization', 'Redis Caching Integration', 'Data Migration & Integrity Audits'],
                'is_featured' => true,
                'is_enabled' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'DevOps, Cloud Hosting & CI/CD Pipelines',
                'slug' => 'devops-cloud-hosting-ci-cd',
                'description' => 'Production server deployment, automated CI/CD pipelines via GitHub Actions, SSL certification, server provisioning (Linux/Nginx), and ongoing monitoring.',
                'features' => ['Automated GitHub Actions CI/CD', 'Linux/Ubuntu Nginx Setup', 'SSL & Firewall Hardening', 'Uptime & Error Telemetry'],
                'is_featured' => true,
                'is_enabled' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($services as $s) {
            Service::create(array_merge($s, [
                'cta_text' => 'Get a Quote',
                'cta_url' => '/contact',
                'seo_title' => $s['name'] . ' - Rohit Gannote',
                'seo_description' => Str::limit($s['description'], 155),
            ]));
        }

        // 6. Work Processes
        WorkProcess::truncate();
        $processes = [
            ['title' => 'Discovery & Blueprint', 'description' => 'In-depth analysis of technical requirements, user user journeys, and database schema planning.', 'display_order' => 1, 'is_enabled' => true],
            ['title' => 'Architecture & Design', 'description' => 'Designing clean database models, API contract specifications, and modular software architecture.', 'display_order' => 2, 'is_enabled' => true],
            ['title' => 'Agile Development', 'description' => 'Writing clean, testable Laravel and modern frontend code with continuous code review and milestone demos.', 'display_order' => 3, 'is_enabled' => true],
            ['title' => 'Testing & Security Audit', 'description' => 'Rigorous automated tests, edge-case validation, SQL query profiling, and vulnerability checks.', 'display_order' => 4, 'is_enabled' => true],
            ['title' => 'Deployment & CI/CD', 'description' => 'Smooth zero-downtime deployment, SSL configuration, server optimization, and live health monitoring.', 'display_order' => 5, 'is_enabled' => true],
            ['title' => 'Maintenance & Support', 'description' => 'Proactive maintenance, performance tuning, and continuous feature enhancements.', 'display_order' => 6, 'is_enabled' => true],
        ];

        foreach ($processes as $proc) {
            WorkProcess::create($proc);
        }
    }
}
