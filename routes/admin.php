<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, '__invoke'])->name('dashboard');

        Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/photo', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::post('profile/resume', [\App\Http\Controllers\Admin\ProfileController::class, 'updateResume'])->name('profile.resume');

        Route::get('homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'edit'])->name('homepage.edit');
        Route::put('homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'update'])->name('homepage.update');

        Route::resource('skills', \App\Http\Controllers\Admin\SkillController::class);
        Route::resource('skill-categories', \App\Http\Controllers\Admin\SkillCategoryController::class);

        Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
        Route::delete('project-screenshots/{screenshot}', [\App\Http\Controllers\Admin\ProjectScreenshotController::class, 'destroy'])->name('project-screenshots.destroy');
        Route::post('project-screenshots/{screenshot}/reorder', [\App\Http\Controllers\Admin\ProjectScreenshotController::class, 'reorder'])->name('project-screenshots.reorder');

        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);

        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);

        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

        Route::get('enquiries', [\App\Http\Controllers\Admin\EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('enquiries/export', [\App\Http\Controllers\Admin\EnquiryController::class, 'export'])->name('enquiries.export');
        Route::get('enquiries/{enquiry}', [\App\Http\Controllers\Admin\EnquiryController::class, 'show'])->name('enquiries.show');
        Route::put('enquiries/{enquiry}', [\App\Http\Controllers\Admin\EnquiryController::class, 'update'])->name('enquiries.update');
        Route::delete('enquiries/{enquiry}', [\App\Http\Controllers\Admin\EnquiryController::class, 'destroy'])->name('enquiries.destroy');
        Route::post('enquiries/{enquiry}/notes', [\App\Http\Controllers\Admin\EnquiryController::class, 'addNote'])->name('enquiries.notes');

        Route::get('navigation', [\App\Http\Controllers\Admin\NavigationController::class, 'index'])->name('navigation.index');
        Route::post('navigation', [\App\Http\Controllers\Admin\NavigationController::class, 'store'])->name('navigation.store');
        Route::put('navigation/{id}', [\App\Http\Controllers\Admin\NavigationController::class, 'update'])->name('navigation.update');
        Route::delete('navigation/{id}', [\App\Http\Controllers\Admin\NavigationController::class, 'destroy'])->name('navigation.destroy');
        Route::post('navigation/reorder', [\App\Http\Controllers\Admin\NavigationController::class, 'reorder'])->name('navigation.reorder');

        Route::get('footer/widgets', [\App\Http\Controllers\Admin\FooterController::class, 'widgetsIndex'])->name('footer.widgets.index');
        Route::post('footer/widgets', [\App\Http\Controllers\Admin\FooterController::class, 'widgetsStore'])->name('footer.widgets.store');
        Route::put('footer/widgets/{id}', [\App\Http\Controllers\Admin\FooterController::class, 'widgetsUpdate'])->name('footer.widgets.update');
        Route::delete('footer/widgets/{id}', [\App\Http\Controllers\Admin\FooterController::class, 'widgetsDestroy'])->name('footer.widgets.destroy');

        Route::get('footer/links', [\App\Http\Controllers\Admin\FooterController::class, 'linksIndex'])->name('footer.links.index');
        Route::post('footer/links', [\App\Http\Controllers\Admin\FooterController::class, 'linksStore'])->name('footer.links.store');
        Route::put('footer/links/{id}', [\App\Http\Controllers\Admin\FooterController::class, 'linksUpdate'])->name('footer.links.update');
        Route::delete('footer/links/{id}', [\App\Http\Controllers\Admin\FooterController::class, 'linksDestroy'])->name('footer.links.destroy');

        Route::get('work-processes', [\App\Http\Controllers\Admin\WorkProcessController::class, 'index'])->name('work-processes.index');
        Route::get('work-processes/create', [\App\Http\Controllers\Admin\WorkProcessController::class, 'create'])->name('work-processes.create');
        Route::post('work-processes', [\App\Http\Controllers\Admin\WorkProcessController::class, 'store'])->name('work-processes.store');
        Route::get('work-processes/{id}/edit', [\App\Http\Controllers\Admin\WorkProcessController::class, 'edit'])->name('work-processes.edit');
        Route::put('work-processes/{id}', [\App\Http\Controllers\Admin\WorkProcessController::class, 'update'])->name('work-processes.update');
        Route::delete('work-processes/{id}', [\App\Http\Controllers\Admin\WorkProcessController::class, 'destroy'])->name('work-processes.destroy');
        Route::post('work-processes/reorder', [\App\Http\Controllers\Admin\WorkProcessController::class, 'reorder'])->name('work-processes.reorder');

        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        Route::get('seo', [\App\Http\Controllers\Admin\SeoController::class, 'edit'])->name('seo.edit');
        Route::put('seo', [\App\Http\Controllers\Admin\SeoController::class, 'update'])->name('seo.update');

        Route::get('sitemap', [\App\Http\Controllers\Admin\SitemapController::class, '__invoke'])->name('sitemap');

        Route::get('maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'edit'])->name('maintenance.edit');
        Route::put('maintenance', [\App\Http\Controllers\Admin\MaintenanceController::class, 'update'])->name('maintenance.update');
        Route::put('maintenance/disable', [\App\Http\Controllers\Admin\MaintenanceController::class, 'disable'])->name('maintenance.disable');
    });
});
