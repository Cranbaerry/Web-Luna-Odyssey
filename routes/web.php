<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PinController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\CharacterController;
use App\Http\Middleware\VerifyCsrfToken;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/features', function () {
    return view('features');
})->name('features');

Route::get('/download', function () {
    return view('download');
})->name('download');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/shop', [ShopController::class, 'view'])
    ->name('shop');

Route::post('/shop', [ShopController::class, 'buy'])
    ->middleware('auth');

Route::get('/leaderboard', [RankingController::class, 'create'])
    ->name('leaderboard');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'view'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/forgot-pin', [PinController::class, 'view'])
    ->name('pin.request');

Route::post('/forgot-pin', [PinController::class, 'send'])
    ->name('pin.email');

Route::post('/setup-pin', [PinController::class, 'setup'])
    ->middleware('auth')
    ->name('pin.setup');

Route::get('/donate', [DonateController::class, 'create'])
    ->middleware('auth')
    ->name('donate');

Route::post('/donate', [DonateController::class, 'payment'])
    ->middleware('auth');

Route::post('/donate/capture/duitku', [DonateController::class, 'paymentCallback'])
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('donate.capture.duitku');

Route::get('/donate/capture/paypal', [DonateController::class, 'paypalCapture'])
    ->middleware('auth')
    ->name('donate.capture.paypal');

Route::get('/donate/cancel', [DonateController::class, 'paypalCancel'])
    ->middleware('auth')
    ->name('donate.cancel');

Route::get('/donate/status', [DonateController::class, 'invoice'])
    ->middleware('auth')
    ->name('donate.status');

Route::get('/dashboard', [UserController::class, 'view'])
    ->middleware('auth')
    ->name('dashboard');

Route::post('/dashboard/redeem', [UserController::class, 'redeem'])
    ->middleware('auth')
    ->name('redeem');

Route::post('/dashboard/tiered-spender', [UserController::class, 'tieredSpender'])
    ->middleware('auth')
    ->name('tiered.spender');

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/admin', [AdminController::class, 'view'])
        ->name('admin');

    Route::post('/admin', [AdminController::class, 'post']);
});


Route::name('api.')->group(function () {
    Route::post('/api/login', [AuthenticatedSessionController::class, 'login'])
        ->name('login');

    Route::post('/api/update-password', [UpdatePasswordController::class, 'store'])
        ->name('update-password');

    Route::post('/api/update-map', [CharacterController::class, 'update_map'])
        ->name('update-map');
});

