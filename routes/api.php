<?php

use App\Http\Controllers\API\BookingsController;
use App\Http\Controllers\API\GeneralController;
use App\Http\Controllers\API\NotificationsController;
use App\Http\Controllers\API\RoomImagesController;
use App\Http\Controllers\API\RoomsController;
use App\Http\Controllers\API\SpecialBookingsController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\VacationBookingsController;
use Illuminate\Support\Facades\Route;

Route::get('/rooms', [RoomsController::class, 'getRooms']);
Route::get('/rooms/{id}', [RoomsController::class, 'getRoom']);
Route::get('/rooms/{id}/photos', [RoomImagesController::class, 'getImagesForRoom']);
Route::post('/rooms/{id}/photos', [RoomImagesController::class, 'postImageToRoom'])->middleware(['auth', 'admin']);
Route::get('/rooms/{id}/photos/{filename}', [RoomImagesController::class, 'getImage']);
Route::delete('/rooms/{id}/photos/{filename}', [RoomImagesController::class, 'deleteImageFromRoom'])->middleware(['auth', 'admin']);

Route::get('/bookings', [BookingsController::class, 'getBookings']);
Route::get('/bookings/{id}', [BookingsController::class, 'getBooking']);
Route::delete('/bookings/{id}', [BookingsController::class, 'deleteBooking'])->middleware(['auth', 'admin']);

Route::get('/special-bookings', [SpecialBookingsController::class, 'getBookings']);
Route::post('/special-bookings', [SpecialBookingsController::class, 'postBooking'])->middleware(['auth', 'admin']);
Route::get('/special-bookings/{id}', [SpecialBookingsController::class, 'getBooking']);
Route::delete('/special-bookings/{id}', [SpecialBookingsController::class, 'deleteBooking'])->middleware(['auth', 'admin']);;

Route::get('/vacation-bookings', [VacationBookingsController::class, 'getBookings']);
Route::post('/vacation-bookings', [VacationBookingsController::class, 'postBooking'])->middleware(['auth', 'admin']);
Route::get('/vacation-bookings/{id}', [VacationBookingsController::class, 'getBooking']);
Route::delete('/vacation-bookings/{id}', [VacationBookingsController::class, 'deleteBooking'])->middleware(['auth', 'admin']);

Route::get('/users', [UsersController::class, 'getUsers']);
Route::get('/users/me', [UsersController::class, 'getCurrentUser']);
Route::patch('/users/me', [UsersController::class, 'patchCurrentUser']);
Route::delete('/users/me', [UsersController::class, 'deleteCurrentUser']);
Route::get('/users/{id}', [UsersController::class, 'getUser'])->middleware(['auth', 'admin']);
Route::patch('/users/{id}', [UsersController::class, 'patchUser'])->middleware(['auth', 'admin']);

Route::get('/general', [GeneralController::class, 'getGeneralInformation']);
Route::patch('/general', [GeneralController::class, 'patchGeneralInformation'])->middleware(['auth', 'admin']);

Route::get('/notifications', [NotificationsController::class, 'getNotifications']);
Route::post('/notifications/{id}', [NotificationsController::class, 'markNotificationAsViewed']);
Route::delete('/notifications/{id}', [NotificationsController::class, 'deleteNotification']);
