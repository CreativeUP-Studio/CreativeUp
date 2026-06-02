<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\ProjectController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\ChatMessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SiteSettingController;

// ── Autenticación ──
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ── Rutas públicas ──
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');

Route::get('/contacto', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');
Route::redirect('/contact', '/contacto');
Route::post('/subscribe', [ContactController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/chat-message', [ContactController::class, 'chatStore'])->name('chat.store');
Route::get('/chat-messages/new', [ContactController::class, 'getNewMessages'])->name('chat.getNewMessages');
Route::get('/chat-messages/history', [ContactController::class, 'getConversationHistory'])->name('chat.getHistory');

// ── Panel Admin ──
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::patch('services/{service}/toggle-active', [AdminServiceController::class, 'toggleActive'])->name('services.toggle-active');
    Route::patch('projects/{project}/toggle-status', [AdminProjectController::class, 'toggleStatus'])->name('projects.toggle-status');
    Route::patch('posts/{post}/toggle-status', [AdminPostController::class, 'toggleStatus'])->name('posts.toggle-status');
    Route::patch('posts/{post}/quick-update', [AdminPostController::class, 'quickUpdate'])->name('posts.quick-update');
    Route::post('posts/upload-media', [AdminPostController::class, 'uploadMedia'])->name('posts.upload-media');
    Route::resource('services', AdminServiceController::class);
    Route::resource('projects', AdminProjectController::class);
    Route::resource('posts', AdminPostController::class);

    Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('leads/export', [LeadController::class, 'export'])->name('leads.export');
    Route::post('leads/bulk', [LeadController::class, 'bulkAction'])->name('leads.bulk');
    Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::put('leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::post('leads/{lead}/reply', [LeadController::class, 'reply'])->name('leads.reply');
    Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

    // Hero Settings
    Route::get('hero', [HeroController::class, 'edit'])->name('hero.edit');
    Route::put('hero', [HeroController::class, 'update'])->name('hero.update');
    Route::delete('hero/image', [HeroController::class, 'deleteImage'])->name('hero.delete-image');

    // Site Settings
    Route::get('settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // Chat Messages
    Route::get('chat', [ChatMessageController::class, 'index'])->name('chat.index');
    Route::get('chat/notifications', [ChatMessageController::class, 'getNotifications'])->name('chat.notifications');
    Route::post('chat/mark-all-read', [ChatMessageController::class, 'markAllAsRead'])->name('chat.markAllAsRead');
    Route::get('chat/{conversationId}', [ChatMessageController::class, 'show'])->name('chat.show');
    Route::post('chat/{conversationId}/reply', [ChatMessageController::class, 'reply'])->name('chat.reply');
    Route::get('chat/{conversationId}/new-messages', [ChatMessageController::class, 'getNewMessages'])->name('chat.getNewMessages');
    Route::delete('chat/{conversationId}', [ChatMessageController::class, 'destroy'])->name('chat.destroy');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});