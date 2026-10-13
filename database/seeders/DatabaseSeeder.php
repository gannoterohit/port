<?php

namespace Database\Seeders;

use App\Models\FooterLink;
use App\Models\FooterWidget;
use App\Models\HomepageSetting;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\User;
use App\Models\WorkProcess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'name' => 'Your Name',
                'title' => 'Full Stack Web Developer',
                'subtitle' => 'Laravel, PHP & MySQL specialist — update this in Admin → Profile',
                'intro' => 'I build custom web applications, admin panels, and REST APIs. Replace this intro with your own from the admin panel.',
                'biography' => '<p>Add your professional biography here from Admin → Profile. Keep experience years consistent with Settings (About → Years of Experience).</p>',
                'experience_text' => 'Add your work history from Admin → Profile (company, role, duration).',
                'location' => 'Your City, India',
                'location_visible' => true,
                'contact_email' => 'admin@example.com',
                'contact_phone' => null,
                'contact_whatsapp' => null,
                'social_links' => [
                    'github' => null,
                    'linkedin' => null,
                    'twitter' => null,
                    'website' => null,
                ],
                'resume_button_visible' => true,
            ]
        );

        HomepageSetting::firstOrCreate([], [
            'hero_heading' => 'Full Stack Web Developer',
            'hero_title' => 'Building Scalable Web Applications',
            'hero_description' => 'I craft clean, efficient, and scalable web applications using modern technologies like Laravel, Vue.js, and Tailwind CSS.',
            'primary_cta_text' => 'Hire Me',
            'primary_cta_url' => '/contact',
            'secondary_cta_text' => 'View My Projects',
            'secondary_cta_url' => '/projects',
            'hero_section_enabled' => true,
            'about_section_enabled' => true,
            'skills_section_enabled' => true,
            'projects_section_enabled' => true,
            'services_section_enabled' => true,
            'work_process_section_enabled' => true,
            'testimonials_section_enabled' => false,
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
                    'slug' => Str::slug($skillData[1]),
                    'category_id' => $skillData[0],
                    'description' => $skillData[1].' development skills',
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
                'demo_url' => null,
                'github_url' => null,
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
                'demo_url' => null,
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
                'demo_url' => null,
                'github_url' => null,
                'is_featured' => true,
                'status' => 'published',
                'display_order' => 3,
            ],
        ];

        foreach ($projectsData as $projectData) {
            Project::firstOrCreate(
                ['slug' => Str::slug($projectData['title'])],
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
                    'seo_title' => $projectData['title'].' - Full Stack Portfolio',
                    'seo_description' => Str::limit(strip_tags($projectData['description']), 160),
                ]
            );
        }

        $servicesData = [
            [
                'name' => 'Web Application Development',
                'description' => 'Custom web application development using modern frameworks like Laravel, React, Vue.js, and more. I build scalable, secure, and performant applications tailored to your business needs.',
                'features' => ['Custom Feature Development', 'API Integration', 'Database Design', 'Testing & Deployment'],
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Beautiful, responsive, and user-friendly interfaces designed to convert visitors into customers. I use modern design tools and best practices to create compelling digital experiences.',
                'features' => ['User Research', 'Wireframing', 'Prototype Design', 'Responsive Design'],
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Technical Consulting',
                'description' => 'Expert technical consultation on architecture, best practices, code reviews, and project strategy. Whether you need guidance on a single decision or an entire project.',
                'features' => ['Code Review', 'Architecture Planning', 'Performance Audit', 'Security Assessment'],
                'is_featured' => false,
                'display_order' => 3,
            ],
            [
                'name' => 'DevOps & Deployment',
                'description' => 'Complete setup and management of CI/CD pipelines, cloud hosting, server configuration, monitoring, and automated deployment processes.',
                'features' => ['CI/CD Setup', 'Cloud Hosting', 'Server Configuration', 'Monitoring & Alerts'],
                'is_featured' => false,
                'display_order' => 4,
            ],
        ];

        foreach ($servicesData as $serviceData) {
            Service::updateOrCreate(
                ['slug' => Str::slug($serviceData['name'])],
                [
                    'name' => $serviceData['name'],
                    'description' => $serviceData['description'],
                    'features' => $serviceData['features'],
                    'price' => null,
                    'is_enabled' => true,
                    'is_featured' => $serviceData['is_featured'],
                    'display_order' => $serviceData['display_order'],
                    'cta_text' => 'Get a Quote',
                    'cta_url' => '/contact',
                    'seo_title' => $serviceData['name'].' Service',
                    'seo_description' => Str::limit(strip_tags($serviceData['description']), 160),
                ]
            );
        }

        // Testimonials intentionally not seeded — add real client feedback from Admin when ready.

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

        Page::firstOrCreate(
            ['slug' => 'terms'],
            [
                'title' => 'Terms of Service',
                'content' => '<h2>Terms of Service</h2><p>These terms govern your use of this website. By accessing or using this site, you agree to these terms.</p>',
                'status' => 'published',
                'show_in_nav' => false,
                'display_order' => 998,
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

            ['footer_widget_id' => $widgetIds['Services'], 'label' => 'Web Application Development', 'url' => '/services/web-application-development', 'target' => '_self', 'display_order' => 1],
            ['footer_widget_id' => $widgetIds['Services'], 'label' => 'UI/UX Design', 'url' => '/services/ui-ux-design', 'target' => '_self', 'display_order' => 2],
            ['footer_widget_id' => $widgetIds['Services'], 'label' => 'Technical Consulting', 'url' => '/services/technical-consulting', 'target' => '_self', 'display_order' => 3],

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
