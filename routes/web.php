<?php

use App\Http\Controllers\AttendeesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\TwoFAController;
use App\Http\Controllers\UnauthorizedController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register-page', [AuthController::class, 'registerPage'])->name('registerPage');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login-page', [AuthController::class, 'loginPage'])->name('loginPage');
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// route for the event 
Route::get('/event', [EventController::class, 'index'])->name('event')->middleware('auth');
Route::get('/event/add-page', [EventController::class, 'addpage'])->name('event.addPage')->middleware('auth');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store')->middleware('auth');
Route::get('/event/edit/{id}', [EventController::class, 'edit'])->name('event.edit')->middleware('auth');
Route::post('/event/update/{id}', [EventController::class, 'update'])->name('event.update')->middleware('auth');
Route::get('/event/delete/{id}', [EventController::class, 'delete'])->name('event.delete')->middleware('auth');

// route for the attendees
Route::get('/attendees', [AttendeesController::class, 'index'])->name('attendees')->middleware('auth');
Route::get('/attendees/add-page', [AttendeesController::class, 'addPage'])->name('attendees.addPage')->middleware('auth');
Route::post('/attendees/store', [AttendeesController::class, 'store'])->name('attendees.store')->middleware('auth');
Route::get('/attendees/edit/{id}', [AttendeesController::class, 'edit'])->name('attendees.edit')->middleware('auth');
Route::post('/attendees/update/{id}', [AttendeesController::class, 'update'])->name('attendees.update')->middleware('auth');
Route::get('/attendees/delete/{id}', [AttendeesController::class, 'delete'])->name('attendees.delete')->middleware('auth');

// route for the unauthorized users 
Route::get('unauthorized', [UnauthorizedController::class, 'unauthorized'])->name('unauthorized');


// route for login with google

Route::controller(GoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});


// 2FA setup
Route::get('/verify-2fa', [AuthController::class, 'verify2faPage'])->name('verify2faPage');
Route::post('/verify-2fa', [AuthController::class, 'verify2fa'])->name('verify2fa');
