<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectScreenshotController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\SkillCategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\WorkProcessController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('index');

        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, '__invoke'])->name('dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::post('profile/resume', [ProfileController::class, 'updateResume'])->name('profile.resume');

        Route::get('homepage', [HomepageController::class, 'edit'])->name('homepage.edit');
        Route::put('homepage', [HomepageController::class, 'update'])->name('homepage.update');

        Route::resource('skills', SkillController::class);
        Route::resource('skill-categories', SkillCategoryController::class);

        Route::resource('projects', ProjectController::class);
        Route::delete('project-screenshots/{screenshot}', [ProjectScreenshotController::class, 'destroy'])->name('project-screenshots.destroy');
        Route::post('project-screenshots/{screenshot}/reorder', [ProjectScreenshotController::class, 'reorder'])->name('project-screenshots.reorder');

        Route::resource('services', ServiceController::class);

        Route::resource('testimonials', TestimonialController::class);

        Route::resource('pages', PageController::class);

        Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('enquiries/export', [EnquiryController::class, 'export'])->name('enquiries.export');
        Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('enquiries.show');
        Route::put('enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('enquiries.update');
        Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');
        Route::post('enquiries/{enquiry}/notes', [EnquiryController::class, 'addNote'])->name('enquiries.notes');

        Route::get('navigation', [NavigationController::class, 'index'])->name('navigation.index');
        Route::post('navigation', [NavigationController::class, 'store'])->name('navigation.store');
        Route::put('navigation/{id}', [NavigationController::class, 'update'])->name('navigation.update');
        Route::delete('navigation/{id}', [NavigationController::class, 'destroy'])->name('navigation.destroy');
        Route::post('navigation/reorder', [NavigationController::class, 'reorder'])->name('navigation.reorder');

        Route::get('footer/widgets', [FooterController::class, 'widgetsIndex'])->name('footer.widgets.index');
        Route::post('footer/widgets', [FooterController::class, 'widgetsStore'])->name('footer.widgets.store');
        Route::put('footer/widgets/{id}', [FooterController::class, 'widgetsUpdate'])->name('footer.widgets.update');
        Route::delete('footer/widgets/{id}', [FooterController::class, 'widgetsDestroy'])->name('footer.widgets.destroy');

        Route::get('footer/links', [FooterController::class, 'linksIndex'])->name('footer.links.index');
        Route::post('footer/links', [FooterController::class, 'linksStore'])->name('footer.links.store');
        Route::put('footer/links/{id}', [FooterController::class, 'linksUpdate'])->name('footer.links.update');
        Route::delete('footer/links/{id}', [FooterController::class, 'linksDestroy'])->name('footer.links.destroy');

        Route::get('work-processes', [WorkProcessController::class, 'index'])->name('work-processes.index');
        Route::get('work-processes/create', [WorkProcessController::class, 'create'])->name('work-processes.create');
        Route::post('work-processes', [WorkProcessController::class, 'store'])->name('work-processes.store');
        Route::get('work-processes/{id}/edit', [WorkProcessController::class, 'edit'])->name('work-processes.edit');
        Route::put('work-processes/{id}', [WorkProcessController::class, 'update'])->name('work-processes.update');
        Route::delete('work-processes/{id}', [WorkProcessController::class, 'destroy'])->name('work-processes.destroy');
        Route::post('work-processes/reorder', [WorkProcessController::class, 'reorder'])->name('work-processes.reorder');

        Route::resource('experiences', ExperienceController::class);
        Route::post('experiences/reorder', [ExperienceController::class, 'reorder'])->name('experiences.reorder');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('seo', [SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo', [SeoController::class, 'update'])->name('seo.update');

        Route::get('sitemap', [SitemapController::class, '__invoke'])->name('sitemap');

        Route::get('maintenance', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
        Route::put('maintenance', [MaintenanceController::class, 'update'])->name('maintenance.update');
        Route::put('maintenance/disable', [MaintenanceController::class, 'disable'])->name('maintenance.disable');
    });
});
