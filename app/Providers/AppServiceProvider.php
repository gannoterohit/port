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
                'siteDescription' => Setting::get('site_description', 'Laravel Backend Developer'),
                'showCustomCursor' => Setting::get('show_custom_cursor', '0') === '1',
                'logo' => Setting::get('website_logo'),
                'favicon' => Setting::get('website_favicon'),
                'defaultSeoTitle' => Setting::get('default_seo_title'),
                'defaultSeoDescription' => Setting::get('default_seo_description'),
                'defaultOgImage' => Setting::get('default_og_image'),
                'homepageSettings' => cache()->remember('homepage_settings', 3600, fn () => HomepageSetting::getInstance()),
                'navItems' => cache()->remember('public_nav_items', 3600, fn () => NavigationItem::visible()->header()->ordered()->get()),
                'footerWidgets' => cache()->remember('public_footer_widgets', 3600, fn () => FooterWidget::enabled()->ordered()->get()),
                'orphanedFooterLinks' => cache()->remember('public_orphaned_footer_links', 3600, fn () => FooterLink::whereNull('footer_widget_id')->ordered()->get()),
            ]);
        });
    }
}
