<?php

use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController as PublicPageController;
use App\Http\Controllers\Public\ProjectController as PublicProjectController;
use App\Http\Controllers\Public\ServiceController as PublicServiceController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Middleware\MaintenanceModeMiddleware;
use Illuminate\Support\Facades\Route;

// Redirect 'login' route to admin login
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Include admin routes
require __DIR__.'/admin.php';

Route::middleware(MaintenanceModeMiddleware::class)->group(function () {
    Route::get('/', [HomeController::class, '__invoke'])->name('home');

    Route::get('/about', [PublicPageController::class, 'about'])->name('about');

    Route::get('/skills', [PublicPageController::class, 'skills'])->name('skills');

    Route::get('/projects', [PublicProjectController::class, 'index'])->name('projects');
    Route::get('/projects/{project}', [PublicProjectController::class, 'show'])->name('projects.show');

    Route::get('/services', [PublicServiceController::class, 'index'])->name('services');
    Route::get('/services/{service}', [PublicServiceController::class, 'show'])->name('services.show');

    Route::get('/resume', [PublicPageController::class, 'resume'])->name('resume');

    Route::get('/contact', [ContactController::class, 'show'])->name('contact');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

    Route::get('/privacy-policy', [PublicPageController::class, 'privacy'])->name('privacy');

    Route::get('/terms', [PublicPageController::class, 'terms'])->name('terms');

    Route::get('/pages/{slug}', [PublicPageController::class, 'show'])->name('page');

    Route::get('/sitemap.xml', [SitemapController::class, '__invoke'])->name('sitemap.xml');

    Route::get('/maintenance', function () {
        return response()->view('errors.maintenance', [], 503);
    })->name('maintenance');

    Route::fallback(function () {
        return response()->view('public.404', [], 404);
    });
});
