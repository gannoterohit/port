<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'label',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = self::where('key', $key)->where('is_active', true)->first();

        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): self
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $value,
                'type' => $type,
                'label' => $key,
            ]
        );
    }

    public static function getAllByGroup(string $group): Collection
    {
        return self::where('group', $group)->where('is_active', true)->get();
    }

    public static function seedDefaults(): void
    {
        $defaults = [
            ['group' => 'general', 'key' => 'website_name', 'value' => 'My Portfolio', 'type' => 'text', 'label' => 'Website Name', 'description' => 'The name of your website', 'is_active' => true, 'sort_order' => 1],
            ['group' => 'general', 'key' => 'website_logo', 'value' => null, 'type' => 'image', 'label' => 'Website Logo', 'description' => 'Upload your logo', 'is_active' => true, 'sort_order' => 2],
            ['group' => 'general', 'key' => 'website_favicon', 'value' => null, 'type' => 'image', 'label' => 'Favicon', 'description' => 'Upload your favicon', 'is_active' => true, 'sort_order' => 3],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'Full Stack Web Developer portfolio', 'type' => 'text', 'label' => 'Site Description', 'description' => 'Short description for SEO', 'is_active' => true, 'sort_order' => 4],
            ['group' => 'general', 'key' => 'contact_email', 'value' => 'hello@example.com', 'type' => 'email', 'label' => 'Contact Email', 'description' => 'Primary contact email', 'is_active' => true, 'sort_order' => 5],
            ['group' => 'general', 'key' => 'contact_phone', 'value' => null, 'type' => 'text', 'label' => 'Phone Number', 'description' => 'Contact phone number (optional)', 'is_active' => true, 'sort_order' => 6],
            ['group' => 'general', 'key' => 'contact_whatsapp', 'value' => null, 'type' => 'text', 'label' => 'WhatsApp Number', 'description' => 'WhatsApp number (optional)', 'is_active' => true, 'sort_order' => 7],
            ['group' => 'general', 'key' => 'website_address', 'value' => null, 'type' => 'text', 'label' => 'Office Address', 'description' => 'Physical address (optional)', 'is_active' => true, 'sort_order' => 8],
            ['group' => 'general', 'key' => 'footer_description', 'value' => 'Full Stack Web Developer crafting scalable web applications and digital experiences.', 'type' => 'textarea', 'label' => 'Footer Description', 'description' => 'Description text shown in the footer', 'is_active' => true, 'sort_order' => 9],
            ['group' => 'general', 'key' => 'copyright_text', 'value' => null, 'type' => 'textarea', 'label' => 'Copyright Text', 'description' => 'Custom copyright text (leave empty for auto-generated)', 'is_active' => true, 'sort_order' => 10],
            ['group' => 'about', 'key' => 'years_experience', 'value' => '2.5+', 'type' => 'text', 'label' => 'Years of Experience', 'description' => 'Number of years of professional experience', 'is_active' => true, 'sort_order' => 1],
            ['group' => 'about', 'key' => 'training_text', 'value' => '+ 6 Months Intensive Training', 'type' => 'text', 'label' => 'Training Info', 'description' => 'Brief training/certificate info shown in about section', 'is_active' => true, 'sort_order' => 2],
            ['group' => 'about', 'key' => 'specialization_text', 'value' => 'Specialized in Laravel, MySQL & Modern Web Development', 'type' => 'text', 'label' => 'Specialization', 'description' => 'Your area of specialization shown in about section', 'is_active' => true, 'sort_order' => 3],
            ['group' => 'theme', 'key' => 'primary_color', 'value' => '#1B560B', 'type' => 'color', 'label' => 'Primary Color', 'description' => 'Primary theme color', 'is_active' => true, 'sort_order' => 1],
            ['group' => 'theme', 'key' => 'secondary_color', 'value' => '#144208', 'type' => 'color', 'label' => 'Secondary Color', 'description' => 'Secondary theme color', 'is_active' => true, 'sort_order' => 2],
            ['group' => 'theme', 'key' => 'enable_dark_mode', 'value' => '1', 'type' => 'boolean', 'label' => 'Enable Dark Mode', 'description' => 'Allow visitors to toggle dark mode', 'is_active' => true, 'sort_order' => 3],
            ['group' => 'social', 'key' => 'social_facebook', 'value' => null, 'type' => 'url', 'label' => 'Facebook URL', 'description' => 'Facebook profile URL', 'is_active' => true, 'sort_order' => 1],
            ['group' => 'social', 'key' => 'social_twitter', 'value' => null, 'type' => 'url', 'label' => 'Twitter/X URL', 'description' => 'Twitter/X profile URL', 'is_active' => true, 'sort_order' => 2],
            ['group' => 'social', 'key' => 'social_linkedin', 'value' => null, 'type' => 'url', 'label' => 'LinkedIn URL', 'description' => 'LinkedIn profile URL', 'is_active' => true, 'sort_order' => 3],
            ['group' => 'social', 'key' => 'social_github', 'value' => null, 'type' => 'url', 'label' => 'GitHub URL', 'description' => 'GitHub profile URL', 'is_active' => true, 'sort_order' => 4],
            ['group' => 'social', 'key' => 'social_youtube', 'value' => null, 'type' => 'url', 'label' => 'YouTube URL', 'description' => 'YouTube channel URL', 'is_active' => true, 'sort_order' => 5],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => null, 'type' => 'url', 'label' => 'Instagram URL', 'description' => 'Instagram profile URL', 'is_active' => true, 'sort_order' => 6],
            ['group' => 'seo', 'key' => 'default_seo_title', 'value' => 'My Portfolio - Full Stack Web Developer', 'type' => 'text', 'label' => 'Default SEO Title', 'description' => 'Default SEO title for all pages', 'is_active' => true, 'sort_order' => 1],
            ['group' => 'seo', 'key' => 'default_seo_description', 'value' => 'Full Stack Web Developer portfolio showcasing projects, skills, and services.', 'type' => 'textarea', 'label' => 'Default SEO Description', 'description' => 'Default meta description', 'is_active' => true, 'sort_order' => 2],
            ['group' => 'seo', 'key' => 'default_og_image', 'value' => null, 'type' => 'image', 'label' => 'Default Social Image', 'description' => 'Default Open Graph image', 'is_active' => true, 'sort_order' => 3],
            ['group' => 'seo', 'key' => 'sitemap_enabled', 'value' => '1', 'type' => 'boolean', 'label' => 'Enable Sitemap', 'description' => 'Generate and serve XML sitemap', 'is_active' => true, 'sort_order' => 4],
            ['group' => 'general', 'key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'label' => 'Maintenance Mode', 'description' => 'Enable maintenance mode for the public site', 'is_active' => true, 'sort_order' => 100],
            ['group' => 'email', 'key' => 'mail_mailer', 'value' => 'smtp', 'type' => 'text', 'label' => 'Mail Mailer', 'description' => 'Mail driver to use', 'is_active' => true, 'sort_order' => 1],
            ['group' => 'email', 'key' => 'mail_host', 'value' => 'smtp.mailtrap.io', 'type' => 'text', 'label' => 'Mail Host', 'description' => 'SMTP server host', 'is_active' => true, 'sort_order' => 2],
            ['group' => 'email', 'key' => 'mail_port', 'value' => '587', 'type' => 'number', 'label' => 'Mail Port', 'description' => 'SMTP server port', 'is_active' => true, 'sort_order' => 3],
            ['group' => 'email', 'key' => 'mail_username', 'value' => null, 'type' => 'text', 'label' => 'Mail Username', 'description' => 'SMTP username', 'is_active' => true, 'sort_order' => 4],
            ['group' => 'email', 'key' => 'mail_password', 'value' => null, 'type' => 'password', 'label' => 'Mail Password', 'description' => 'SMTP password', 'is_active' => true, 'sort_order' => 5],
            ['group' => 'email', 'key' => 'mail_encryption', 'value' => 'tls', 'type' => 'text', 'label' => 'Mail Encryption', 'description' => 'SMTP encryption (tls/ssl)', 'is_active' => true, 'sort_order' => 6],
            ['group' => 'email', 'key' => 'mail_from_address', 'value' => 'hello@example.com', 'type' => 'email', 'label' => 'From Email Address', 'description' => 'The email address emails are sent from', 'is_active' => true, 'sort_order' => 7],
            ['group' => 'email', 'key' => 'mail_from_name', 'value' => null, 'type' => 'text', 'label' => 'From Name', 'description' => 'The name emails are sent from', 'is_active' => true, 'sort_order' => 8],
            ['group' => 'email', 'key' => 'notify_admin_on_enquiry', 'value' => '1', 'type' => 'boolean', 'label' => 'Notify Admin on Enquiry', 'description' => 'Send email notification to admin when a contact form enquiry is submitted', 'is_active' => true, 'sort_order' => 9],
            ['group' => 'email', 'key' => 'send_enquiry_confirmation', 'value' => '1', 'type' => 'boolean', 'label' => 'Send Enquiry Confirmation', 'description' => 'Send a confirmation email to the visitor after they submit the contact form', 'is_active' => true, 'sort_order' => 10],
        ];

        foreach ($defaults as $setting) {
            self::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
