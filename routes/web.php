<?php

use App\Http\Controllers\App\BookingsController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\RoomController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/rooms/{id}', [RoomController::class, 'viewRoom']);
Route::get('/rooms/{id}/book', [RoomController::class, 'viewRoomBooking']);
Route::post('/rooms/{id}/book', [RoomController::class, 'bookRoom'])->middleware(['auth', 'verified', 'active']);

Route::post('/bookings', [BookingsController::class, 'findAvailableSlots'])->middleware('auth');
Route::get('/bookings', [BookingsController::class, 'findAvailableSlots'])->middleware('auth');
Route::get('/bookings/{id}', [BookingsController::class, 'viewBooking'])->middleware('auth');
Route::delete('/bookings/{id}', [BookingsController::class, 'deleteBooking'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'viewProfile']);
Route::get('/profile/bookings', [ProfileController::class, 'viewBookings']);

Route::get('/password/change', [ChangePasswordController::class, 'viewChangePasswordForm'])->name('password.change');
Route::post('/password/change', [ChangePasswordController::class, 'changePassword'])->name('password.change');
