<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredWorkers = \App\Models\WorkerProfile::with('user', 'service')
        ->where('is_featured', true)
        ->where('is_available', true)
        ->whereHas('user', function($q) { $q->where('is_verified', true); })
        ->inRandomOrder()
        ->limit(4)
        ->get();

    // Fetch dynamic categories based on worker counts
    $popularCategories = \App\Models\Service::withCount('workerProfiles')
        ->orderByDesc('worker_profiles_count')
        ->limit(6)
        ->get();

    // Fetch recent successful activities (accepted or completed requests)
    $recentActivity = \App\Models\Request::with(['user', 'worker', 'worker.workerProfile.service'])
        ->whereIn('status', ['accepted', 'completed'])
        ->latest()
        ->limit(3)
        ->get();
        
    return view('welcome', compact('featuredWorkers', 'popularCategories', 'recentActivity'));
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/workers', [\App\Http\Controllers\Admin\WorkerController::class, 'index'])->name('workers.index');
    Route::get('/workers/{id}', [\App\Http\Controllers\Admin\WorkerController::class, 'show'])->name('workers.show');
    Route::post('/workers/{id}/verify', [\App\Http\Controllers\Admin\WorkerController::class, 'verify'])->name('workers.verify');
    Route::post('/workers/{id}/unverify', [\App\Http\Controllers\Admin\WorkerController::class, 'unverify'])->name('workers.unverify');
    Route::post('/workers/{id}/feature', [\App\Http\Controllers\Admin\WorkerController::class, 'feature'])->name('workers.feature');
    Route::post('/workers/{id}/unfeature', [\App\Http\Controllers\Admin\WorkerController::class, 'unfeature'])->name('workers.unfeature');
    
    // Services Management
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->only(['index', 'store', 'destroy']);
    
    // Job Board Management
    Route::get('/jobs', [\App\Http\Controllers\Admin\JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [\App\Http\Controllers\Admin\JobController::class, 'show'])->name('jobs.show');
    Route::delete('/jobs/{job}', [\App\Http\Controllers\Admin\JobController::class, 'destroy'])->name('jobs.destroy');
    Route::post('/jobs/{job}/close', [\App\Http\Controllers\Admin\JobController::class, 'close'])->name('jobs.close');

    // Transactions & Disputes
    Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/disputes', [\App\Http\Controllers\Admin\TransactionController::class, 'disputes'])->name('transactions.disputes');
    Route::post('/transactions/{transaction}/resolve', [\App\Http\Controllers\Admin\TransactionController::class, 'resolve'])->name('transactions.resolve');
});

// Public search
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');

// Locale Switcher
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// Subscriptions (workers)
Route::middleware(['auth'])->group(function () {
    Route::get('/subscribe', [\App\Http\Controllers\SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscribe', [\App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscriptions.store');
    
    // Worker Profile Management
    Route::get('/worker-profile', [\App\Http\Controllers\WorkerProfileController::class, 'edit'])->name('worker-profile.edit');
    Route::patch('/worker-profile', [\App\Http\Controllers\WorkerProfileController::class, 'update'])->name('worker-profile.update');
    Route::post('/worker-profile/availability', [\App\Http\Controllers\WorkerProfileController::class, 'updateAvailability'])->name('worker-profile.availability');
    Route::delete('/worker-profile/image/{id}', [\App\Http\Controllers\WorkerProfileController::class, 'destroyPortfolioImage'])->name('worker-profile.image.destroy');
    Route::post('/favorites/{worker_profile_id}', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Verification Requests
    Route::get('/verify', [\App\Http\Controllers\VerificationController::class, 'create'])->name('verification.create');
    Route::post('/verify', [\App\Http\Controllers\VerificationController::class, 'store'])->name('verification.store');
});

// Admin Review
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/verification-requests', [\App\Http\Controllers\VerificationController::class, 'index'])->name('verification.index');
    Route::patch('/verification-requests/{id}', [\App\Http\Controllers\VerificationController::class, 'update'])->name('verification.update');
});

// Public Worker Profile View (accessible to auth users)
Route::get('/worker/{id}', [\App\Http\Controllers\WorkerProfileController::class, 'show'])->name('worker.show')->middleware('auth');
Route::post('/worker/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::post('/reviews/{id}/reply', [\App\Http\Controllers\ReviewController::class, 'reply'])->name('reviews.reply')->middleware('auth');
Route::post('/worker/{id}/request', [\App\Http\Controllers\ServiceRequestController::class, 'store'])->name('requests.store')->middleware('auth');
Route::patch('/requests/{id}/status', [\App\Http\Controllers\ServiceRequestController::class, 'updateStatus'])->name('requests.update-status')->middleware('auth');
Route::post('/requests/{id}/accept-quote', [\App\Http\Controllers\ServiceRequestController::class, 'acceptQuote'])->name('requests.accept-quote')->middleware('auth');

// Chat System
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{id}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/messages/{id}', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    Route::get('/support/chat', [\App\Http\Controllers\ChatController::class, 'support'])->name('chat.support');

    // Public Job Board (Marketplace)
    Route::get('/jobs', [\App\Http\Controllers\PublicJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [\App\Http\Controllers\PublicJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [\App\Http\Controllers\PublicJobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/my-jobs', [\App\Http\Controllers\PublicJobController::class, 'myJobs'])->name('jobs.my-jobs');
    Route::get('/jobs/{job}', [\App\Http\Controllers\PublicJobController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{job}/bid', [\App\Http\Controllers\PublicJobController::class, 'bid'])->name('jobs.bid');
    Route::post('/bids/{bid}/accept', [\App\Http\Controllers\PublicJobController::class, 'acceptBid'])->name('jobs.accept-bid');
    
    // Wallet & Payments
    Route::get('/wallet', [\App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    Route::get('/pay/{request}', [\App\Http\Controllers\WalletController::class, 'showPayment'])->name('wallet.pay');
    Route::post('/pay/{request}', [\App\Http\Controllers\WalletController::class, 'processPayment'])->name('wallet.process');
    Route::post('/release-funds/{request}', [\App\Http\Controllers\WalletController::class, 'releaseFunds'])->name('wallet.release');
    Route::post('/dispute/{transaction}', [\App\Http\Controllers\WalletController::class, 'openDispute'])->name('wallet.dispute');
});
