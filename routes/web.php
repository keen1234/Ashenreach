<?php

use App\Http\Controllers\VerificationCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('pages.auth.login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
});

// Custom email verification code routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify-code', [VerificationCodeController::class, 'show'])->name('verification.verify-code');
    Route::post('/email/verify-code', [VerificationCodeController::class, 'verify'])->name('verification.verify-code.post');
});

require __DIR__.'/settings.php';
