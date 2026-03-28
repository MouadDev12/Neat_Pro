<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EcommerceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Social OAuth
Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');

// Dev-only mock OAuth (auto-login without real API keys)
if (app()->environment('local')) {
    Route::get('/dev/social/{provider}', function (string $provider) {
        abort_unless(in_array($provider, ['google', 'github']), 404);

        $fakeData = [
            'google' => [
                'name'       => 'Google Demo User',
                'email'      => 'google-demo@neat-dashboard.dev',
                'avatar'     => 'https://ui-avatars.com/api/?name=Google+Demo&background=4285F4&color=fff&size=128',
                'provider_id'=> 'google_demo_001',
            ],
            'github' => [
                'name'       => 'GitHub Demo User',
                'email'      => 'github-demo@neat-dashboard.dev',
                'avatar'     => 'https://ui-avatars.com/api/?name=GitHub+Demo&background=24292e&color=fff&size=128',
                'provider_id'=> 'github_demo_001',
            ],
        ];

        $data = $fakeData[$provider];
        $user = \App\Models\User::updateOrCreate(
            ['provider' => $provider, 'provider_id' => $data['provider_id']],
            [
                'name'     => $data['name'],
                'email'    => $data['email'],
                'avatar'   => $data['avatar'],
                'password' => bcrypt(str()->random(32)),
                'role'     => 'manager',
            ]
        );

        \Illuminate\Support\Facades\Auth::login($user, true);
        return redirect()->route('dashboard');
    })->name('dev.social');
}

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Locale switcher
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session(['locale' => $locale]);
        if (auth()->check()) auth()->user()->update(['locale' => $locale]);
    }
    return back();
})->name('locale.switch');

// Authenticated routes
Route::middleware(['auth', 'locale'])->group(function () {

    Route::get('/', fn() => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/export-pdf', [OrderController::class, 'exportPdf'])->name('orders.export-pdf');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/export-csv', [OrderController::class, 'exportCsv'])->name('orders.export-csv');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // CRM
    Route::get('/crm', [CrmController::class, 'index'])->name('crm.index');
    Route::get('/crm/{customer}', [CrmController::class, 'show'])->name('crm.show');
    Route::post('/crm', [CrmController::class, 'store'])->name('crm.store');
    Route::delete('/crm/{customer}', [CrmController::class, 'destroy'])->name('crm.destroy');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Ecommerce
    Route::get('/ecommerce', [EcommerceController::class, 'index'])->name('ecommerce.index');
    Route::post('/ecommerce', [EcommerceController::class, 'store'])->name('ecommerce.store');
    Route::put('/ecommerce/{product}', [EcommerceController::class, 'update'])->name('ecommerce.update');
    Route::delete('/ecommerce/{product}', [EcommerceController::class, 'destroy'])->name('ecommerce.destroy');

    // Users (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});
