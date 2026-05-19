<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\ProjectsSearchController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\PartnerController;

Route::view('/', 'pages.home')->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::view('/about', 'pages.about')->name('about');
Route::view('/services', 'pages.services')->name('services');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')
    ->name('blog.show');
Route::view('/projects', 'pages.projects.index')->name('projects.index');
Route::get('/projects/_search', ProjectsSearchController::class)->name('projects.search');
Route::view('/projects/finished', 'pages.projects.finished')->name('projects.finished');
Route::view('/projects/under-construction', 'pages.projects.under-construction')->name('projects.under_construction');
Route::view('/projects/{slug}', 'pages.projects.show')->name('projects.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::get('/password/reset', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/password/email', [PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'update'])->name('password.update');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AdminAuthController::class, 'logoutGet'])->name('logout.get');

    Route::middleware(['admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('projects', ProjectController::class)->except(['show'])->names('projects');
        Route::resource('blogs', AdminBlogController::class)->except(['show'])->names('blogs');
        Route::resource('services', ServiceController::class)->except(['show'])->names('services');
        Route::resource('team', TeamMemberController::class)->except(['show'])->names('team');
        Route::resource('partners', PartnerController::class)->except(['show'])->names('partners');
        Route::resource('users', UserController::class)->except(['show'])->names('users');

        Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{contactMessage}/read', [ContactMessageController::class, 'markRead'])->name('messages.read');
        Route::post('/messages/{contactMessage}/unread', [ContactMessageController::class, 'markUnread'])->name('messages.unread');
        Route::delete('/messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
    });
});
