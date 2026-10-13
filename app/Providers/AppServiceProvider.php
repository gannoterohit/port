<?php

namespace App\Providers;

use App\Models\FooterLink;
use App\Models\FooterWidget;
use App\Models\HomepageSetting;
use App\Models\NavigationItem;
use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('public.*', function ($view) {
            $view->with([
                'profile' => cache()->remember('profile', 3600, fn () => Profile::getInstance()),
                'websiteName' => Setting::get('website_name', 'Portfolio'),
                'siteDescription' => Setting::get('site_description', 'Full Stack Web Developer'),
                'primaryColor' => Setting::get('primary_color', '#3b82f6'),
                'secondaryColor' => Setting::get('secondary_color', '#1e40af'),
                'logo' => Setting::get('website_logo'),
                'favicon' => Setting::get('website_favicon'),
                'defaultSeoTitle' => Setting::get('default_seo_title'),
                'defaultSeoDescription' => Setting::get('default_seo_description'),
                'defaultOgImage' => Setting::get('default_og_image'),
                'homepageSettings' => cache()->remember('homepage_settings', 3600, fn () => HomepageSetting::getInstance()),
                'navItems' => NavigationItem::visible()->header()->ordered()->get(),
                'footerWidgets' => FooterWidget::enabled()->ordered()->get(),
                'orphanedFooterLinks' => FooterLink::whereNull('footer_widget_id')->ordered()->get(),
            ]);
        });
    }
}
