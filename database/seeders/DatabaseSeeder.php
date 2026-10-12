<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\HomepageSetting;
use App\Models\SkillCategory;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Page;
use App\Models\NavigationItem;
use App\Models\FooterWidget;
use App\Models\FooterLink;
use App\Models\WorkProcess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
                'role' => 'admin',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => false,
                'role' => 'user',
            ]
        );

        Setting::seedDefaults();

        Profile::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'name' => 'Alex Morgan',
                'title' => 'Full Stack Web Developer',
                'subtitle' => 'Building scalable web applications with Laravel & Vue.js',
                'intro' => 'I build modern web applications that scale.',
                'biography' => '<p>Hello! I\'m a full-stack web developer specializing in building scalable, high-performance web applications. With over 3 years of experience in both frontend and backend development, I create clean, efficient, and user-focused digital experiences.</p><p>My expertise spans modern PHP frameworks, JavaScript ecosystems, database design, and cloud deployment. I\'m passionate about writing clean, maintainable code and delivering projects on time and within budget.</p>',
                'experience_text' => 'Senior Developer at TechCorp (2022-Present), Mid-Level Developer at StartUpXYZ (2020-2022), Junior Developer at WebAgency (2019-2020)',
                'location' => 'San Francisco, CA',
                'location_visible' => true,
                'contact_email' => 'hello@example.com',
                'contact_phone' => '+1 (555) 123-4567',
                'contact_whatsapp' => '+15551234567',
                'social_links' => [
                    'github' => 'https://github.com/example',
                    'linkedin' => 'https://linkedin.com/in/example',
                    'twitter' => 'https://twitter.com/example',
                    'website' => 'https://example.com',
                ],
                'resume_button_visible' => true,
            ]
        );

        HomepageSetting::firstOrCreate([], [
            'hero_heading' => 'Full Stack Web Developer',
            'hero_title' => 'Building Scalable Web Applications',
            'hero_description' => 'I craft clean, efficient, and scalable web applications using modern technologies like Laravel, Vue.js, and Tailwind CSS.',
            'primary_cta_text' => 'View My Work',
            'primary_cta_url' => '/projects',
            'secondary_cta_text' => 'Contact Me',
            'secondary_cta_url' => '/contact',
            'hero_section_enabled' => true,
            'about_section_enabled' => true,
            'skills_section_enabled' => true,
            'projects_section_enabled' => true,
            'services_section_enabled' => true,
            'work_process_section_enabled' => true,
            'testimonials_section_enabled' => true,
            'contact_cta_section_enabled' => true,
            'contact_cta_heading' => 'Ready to work together?',
            'contact_cta_description' => 'Let\'s discuss your next project. I\'m available for freelance work.',
            'section_order' => json_encode(['hero', 'about', 'skills', 'projects', 'services', 'work_process', 'testimonials', 'contact_cta']),
        ]);

        $backend = SkillCategory::firstOrCreate(
            ['slug' => 'backend'],
            ['name' => 'Backend', 'color' => '#3b82f6', 'display_order' => 1, 'is_enabled' => true]
        );

        $frontend = SkillCategory::firstOrCreate(
            ['slug' => 'frontend'],
            ['name' => 'Frontend', 'color' => '#ef4444', 'display_order' => 2, 'is_enabled' => true]
        );

        $database = SkillCategory::firstOrCreate(
            ['slug' => 'database'],
            ['name' => 'Database', 'color' => '#f59e0b', 'display_order' => 3, 'is_enabled' => true]
        );

        $tools = SkillCategory::firstOrCreate(
            ['slug' => 'tools'],
            ['name' => 'Tools', 'color' => '#10b981', 'display_order' => 4, 'is_enabled' => true]
        );

        $skillsData = [
            [$backend->id, 'Laravel', 5],
            [$backend->id, 'PHP', 4],
            [$backend->id, 'Node.js', 3],
            [$backend->id, 'Python', 3],
            [$frontend->id, 'JavaScript', 5],
            [$frontend->id, 'Vue.js', 4],
            [$frontend->id, 'React', 3],
            [$frontend->id, 'Tailwind CSS', 5],
            [$frontend->id, 'Alpine.js', 4],
            [$database->id, 'MySQL', 5],
            [$database->id, 'PostgreSQL', 4],
            [$tools->id, 'Git', 5],
            [$tools->id, 'Docker', 4],
            [$tools->id, 'AWS', 3],
        ];

        foreach ($skillsData as $skillData) {
            Skill::firstOrCreate(
                ['name' => $skillData[1]],
                [
                    'slug' => \Illuminate\Support\Str::slug($skillData[1]),
                    'category_id' => $skillData[0],
                    'description' => $skillData[1] . ' development skills',
                    'proficiency' => $skillData[2],
                    'display_order' => $skillData[2],
                    'is_enabled' => true,
                    'is_featured' => $skillData[2] >= 4,
                ]
            );
        }

        $projectsData = [
            [
                'title' => 'E-Commerce Dashboard',
                'description' => 'A comprehensive admin dashboard for an e-commerce platform built with Laravel, Vue.js, and Tailwind CSS. Features include real-time analytics, inventory management, order tracking, and customer insights.',
                'category' => 'E-Commerce',
                'tech_stack' => ['Laravel', 'Vue.js', 'Tailwind CSS', 'MySQL', 'Chart.js'],
                'purpose' => 'Built to streamline e-commerce operations for a growing retail business.',
                'key_features' => 'Real-time analytics dashboard | Inventory management system | Order tracking module | Customer CRM integration | Export functionality',
                'role' => 'Full Stack Lead Developer',
                'challenges' => 'Handling large datasets and real-time updates while maintaining performance.',
                'solutions' => 'Implemented Redis caching and WebSocket connections for real-time data.',
                'demo_url' => 'https://demo.example.com',
                'github_url' => 'https://github.com/example/ecommerce-dashboard',
                'is_featured' => true,
                'status' => 'published',
                'display_order' => 1,
            ],
            [
                'title' => 'Portfolio CMS',
                'description' => 'A custom-built content management system for portfolio websites, featuring project showcases, skill management, and testimonial handling. Built with Laravel 11 and modern frontend tooling.',
                'category' => 'CMS',
                'tech_stack' => ['Laravel 11', 'Alpine.js', 'Vite', 'Tailwind CSS'],
                'purpose' => 'Created to replace a legacy WordPress-based portfolio site.',
                'key_features' => 'Project management | Skill categorization | Testimonial handling | SEO optimization | Theme customization',
                'role' => 'Full Stack Developer',
                'challenges' => 'Building a flexible CMS that can be customized per client needs.',
                'solutions' => 'Used Laravel\'s polymorphic relationships and a modular architecture.',
                'demo_url' => 'https://portfolio.example.com',
                'github_url' => null,
                'is_featured' => true,
                'status' => 'published',
                'display_order' => 2,
            ],
            [
                'title' => 'TaskFlow App',
                'description' => 'A productivity application that helps teams manage tasks and collaborate in real-time. Features include Kanban boards, calendar integration, and team chat.',
                'category' => 'Productivity',
                'tech_stack' => ['Laravel', 'Inertia.js', 'React', 'PostgreSQL'],
                'purpose' => 'Designed to improve team collaboration and task tracking.',
                'key_features' => 'Kanban boards | Calendar integration | Team chat | File sharing | Time tracking',
                'role' => 'Backend Developer',
                'challenges' => 'Implementing real-time updates without compromising performance.',
                'solutions' => 'Used Laravel Echo with WebSockets and queue workers for background processing.',
                'demo_url' => 'https://app.example.com',
                'github_url' => null,
                'is_featured' => false,
                'status' => 'published',
                'display_order' => 3,
            ],
        ];

        foreach ($projectsData as $projectData) {
            Project::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($projectData['title'])],
                [
                    'title' => $projectData['title'],
                    'description' => $projectData['description'],
                    'category' => $projectData['category'],
                    'tech_stack' => $projectData['tech_stack'],
                    'purpose' => $projectData['purpose'],
                    'key_features' => $projectData['key_features'],
                    'role' => $projectData['role'],
                    'challenges' => $projectData['challenges'],
                    'solutions' => $projectData['solutions'],
                    'demo_url' => $projectData['demo_url'],
                    'github_url' => $projectData['github_url'],
                    'is_featured' => $projectData['is_featured'],
                    'status' => $projectData['status'],
                    'display_order' => $projectData['display_order'],
                    'published_at' => now(),
                    'seo_title' => $projectData['title'] . ' - Full Stack Portfolio',
                    'seo_description' => \Illuminate\Support\Str::limit(strip_tags($projectData['description']), 160),
                ]
            );
        }

        $servicesData = [
            [
                'name' => 'Web Application Development',
                'description' => 'Custom web application development using modern frameworks like Laravel, React, Vue.js, and more. I build scalable, secure, and performant applications tailored to your business needs.',
                'features' => ['Custom Feature Development', 'API Integration', 'Database Design', 'Testing & Deployment'],
                'price' => 2999,
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Beautiful, responsive, and user-friendly interfaces designed to convert visitors into customers. I use modern design tools and best practices to create compelling digital experiences.',
                'features' => ['User Research', 'Wireframing', 'Prototype Design', 'Responsive Design'],
                'price' => 1499,
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Technical Consulting',
                'description' => 'Expert technical consultation on architecture, best practices, code reviews, and project strategy. Whether you need guidance on a single decision or an entire project.',
                'features' => ['Code Review', 'Architecture Planning', 'Performance Audit', 'Security Assessment'],
                'price' => 199,
                'is_featured' => false,
                'display_order' => 3,
            ],
            [
                'name' => 'DevOps & Deployment',
                'description' => 'Complete setup and management of CI/CD pipelines, cloud hosting, server configuration, monitoring, and automated deployment processes.',
                'features' => ['CI/CD Setup', 'Cloud Hosting', 'Server Configuration', 'Monitoring & Alerts'],
                'price' => 999,
                'is_featured' => false,
                'display_order' => 4,
            ],
        ];

        foreach ($servicesData as $serviceData) {
            Service::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($serviceData['name'])],
                [
                    'name' => $serviceData['name'],
                    'description' => $serviceData['description'],
                    'features' => $serviceData['features'],
                    'price' => $serviceData['price'],
                    'is_enabled' => true,
                    'is_featured' => $serviceData['is_featured'],
                    'display_order' => $serviceData['display_order'],
                    'cta_text' => 'Get a Quote',
                    'cta_url' => '/contact',
                    'seo_title' => $serviceData['name'] . ' Service',
                    'seo_description' => \Illuminate\Support\Str::limit(strip_tags($serviceData['description']), 160),
                ]
            );
        }

        $testimonialsData = [
            ['name' => 'Sarah Johnson', 'role_company' => 'CEO, TechStart', 'feedback' => 'Working with this developer transformed our business. They delivered a robust e-commerce platform that exceeded our expectations. The attention to detail and communication were exceptional.', 'is_published' => true, 'display_order' => 1],
            ['name' => 'Michael Chen', 'role_company' => 'Founder, DesignLab', 'feedback' => 'Outstanding work on our new website! The attention to detail, performance optimization, and clean code quality made this project a seamless experience. Highly recommended.', 'is_published' => true, 'display_order' => 2],
            ['name' => 'Emily Rodriguez', 'role_company' => 'CTO, MarketPeak', 'feedback' => 'They took our complex requirements and turned them into a beautiful, functional product. The project was delivered on time and under budget. We couldn\'t be happier!', 'is_published' => true, 'display_order' => 3],
        ];

        foreach ($testimonialsData as $testimonial) {
            Testimonial::firstOrCreate(
                ['name' => $testimonial['name'], 'role_company' => $testimonial['role_company']],
                $testimonial
            );
        }

        Page::firstOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About',
                'content' => '<h2>About Me</h2><p>Detailed information about the team and approach.</p>',
                'status' => 'published',
                'show_in_nav' => false,
                'display_order' => 1,
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Privacy Policy',
                'content' => '<h2>Privacy Policy</h2><p>Your privacy is important to us. This page outlines what data we collect and how we use it.</p>',
                'status' => 'published',
                'show_in_nav' => false,
                'display_order' => 999,
            ]
        );

        $navItemsData = [
            ['label' => 'Home', 'url' => '/', 'target' => '_self', 'is_visible' => true, 'display_order' => 1, 'nav_type' => 'header'],
            ['label' => 'About', 'url' => '/about', 'target' => '_self', 'is_visible' => true, 'display_order' => 2, 'nav_type' => 'header'],
            ['label' => 'Skills', 'url' => '/skills', 'target' => '_self', 'is_visible' => true, 'display_order' => 3, 'nav_type' => 'header'],
            ['label' => 'Projects', 'url' => '/projects', 'target' => '_self', 'is_visible' => true, 'display_order' => 4, 'nav_type' => 'header'],
            ['label' => 'Services', 'url' => '/services', 'target' => '_self', 'is_visible' => true, 'display_order' => 5, 'nav_type' => 'header'],
            ['label' => 'Resume', 'url' => '/resume', 'target' => '_self', 'is_visible' => true, 'display_order' => 6, 'nav_type' => 'header'],
            ['label' => 'Contact', 'url' => '/contact', 'target' => '_self', 'is_visible' => true, 'display_order' => 7, 'nav_type' => 'header'],
        ];

        foreach ($navItemsData as $navItem) {
            NavigationItem::firstOrCreate(
                ['label' => $navItem['label']],
                $navItem
            );
        }

        $widgetsData = [
            ['title' => 'Quick Links', 'content' => null, 'is_enabled' => true, 'display_order' => 1],
            ['title' => 'Services', 'content' => null, 'is_enabled' => true, 'display_order' => 2],
            ['title' => 'Contact', 'content' => null, 'is_enabled' => true, 'display_order' => 3],
        ];

        $widgetIds = [];
        foreach ($widgetsData as $widgetData) {
            $widget = FooterWidget::firstOrCreate(
                ['title' => $widgetData['title']],
                $widgetData
            );
            $widgetIds[$widget->title] = $widget->id;
        }

        $linksData = [
            ['footer_widget_id' => $widgetIds['Quick Links'], 'label' => 'Home', 'url' => '/', 'target' => '_self', 'display_order' => 1],
            ['footer_widget_id' => $widgetIds['Quick Links'], 'label' => 'About', 'url' => '/about', 'target' => '_self', 'display_order' => 2],
            ['footer_widget_id' => $widgetIds['Quick Links'], 'label' => 'Projects', 'url' => '/projects', 'target' => '_self', 'display_order' => 3],
            ['footer_widget_id' => $widgetIds['Quick Links'], 'label' => 'Contact', 'url' => '/contact', 'target' => '_self', 'display_order' => 4],

            ['footer_widget_id' => $widgetIds['Services'], 'label' => 'Web Development', 'url' => '/services', 'target' => '_self', 'display_order' => 1],
            ['footer_widget_id' => $widgetIds['Services'], 'label' => 'UI/UX Design', 'url' => '/services', 'target' => '_self', 'display_order' => 2],
            ['footer_widget_id' => $widgetIds['Services'], 'label' => 'Consulting', 'url' => '/services', 'target' => '_self', 'display_order' => 3],

            ['footer_widget_id' => null, 'label' => 'Privacy Policy', 'url' => '/privacy-policy', 'target' => '_self', 'display_order' => 1],
            ['footer_widget_id' => null, 'label' => 'Terms of Service', 'url' => '/terms', 'target' => '_self', 'display_order' => 2],
        ];

        foreach ($linksData as $linkData) {
            FooterLink::firstOrCreate(
                ['label' => $linkData['label'], 'url' => $linkData['url']],
                $linkData
            );
        }

        $processesData = [
            ['title' => 'Discovery', 'description' => 'Research and analyze project requirements to build a solid foundation.', 'display_order' => 1, 'is_enabled' => true],
            ['title' => 'Design', 'description' => 'Create wireframes and visual designs that align with your brand identity.', 'display_order' => 2, 'is_enabled' => true],
            ['title' => 'Development', 'description' => 'Build responsive, scalable applications using modern development practices.', 'display_order' => 3, 'is_enabled' => true],
            ['title' => 'Testing', 'description' => 'Comprehensive testing to ensure quality, performance, and security.', 'display_order' => 4, 'is_enabled' => true],
            ['title' => 'Launch', 'description' => 'Deploy the application and monitor performance for optimal results.', 'display_order' => 5, 'is_enabled' => true],
            ['title' => 'Support', 'description' => 'Ongoing maintenance and support to keep everything running smoothly.', 'display_order' => 6, 'is_enabled' => true],
        ];

        foreach ($processesData as $processData) {
            WorkProcess::firstOrCreate(
                ['title' => $processData['title']],
                $processData
            );
        }
    }
}
