<?php

use App\Http\Controllers\CMS\BookingsController;
use App\Http\Controllers\CMS\RoomsController;
use App\Http\Controllers\CMS\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(url('/cms/dashboard'));
});
Route::get('/dashboard', function () {
    return view('cms.dashboard');
})->middleware('auth')->middleware('admin');

Route::get('/bookings', [BookingsController::class, 'viewAllBookings']);

Route::get('/users', [UsersController::class, 'viewAllUsers']);
Route::get('/users/{id}', [UsersController::class, 'activateUserAndViewAllUsers']);

Route::get('/rooms', [RoomsController::class, 'viewAllRooms']);
Route::get('/rooms/{id}', [RoomsController::class, 'viewRoom']);
Route::post('/rooms/{id}', [RoomsController::class, 'updateAndViewRoom']);


