<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SocialAuthController;

use Illuminate\Support\Facades\Route;

Route::middleware(['guest','sanitizer','maintenance.mode'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register')->middleware('user.register');
    Route::post('register', [RegisteredUserController::class, 'store'])->middleware('user.register');

    Route::post('registration/verify', [RegisteredUserController::class, 'verify'])->name('registration.verify')->middleware('user.register');

    Route::get('registration/verify/code', [RegisteredUserController::class, 'verifyCode'])->name('registration.verify.code')->middleware('user.register');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('password/code/verify', [PasswordResetLinkController::class, 'passwordResetCodeVerify'])->name('password.verify.code');
    Route::post('password/code/verify', [PasswordResetLinkController::class, 'emailVerificationCode'])->name('email.password.verify.code');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware(['auth','maintenance.mode'])->name('user.')->group(function () {
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

  //SOCIAL LOGIN CONTROLLER

Route::middleware(['maintenance.mode'])->group(function () {

    Route::controller(SocialAuthController::class)->name('social.')->group(function () {
        Route::get('login/{medium}', 'redirectToOauth')->name('login');
        Route::get('login/{medium}/callback', 'handleOauthCallback')->name('login.callback');

        Route::get('login/facebook', [SocialAuthController::class, 'redirectToOauth'])->name('facebook.login');
        Route::get('login/facebook/callback', [SocialAuthController::class, 'handleOauthCallback'])->name('facebook.callback');

        Route::get('login/google', [SocialAuthController::class, 'redirectToOauth'])->name('google.login');
        Route::get('login/google/callback', [SocialAuthController::class, 'handleOauthCallback'])->name('google.callback');
    });
});

