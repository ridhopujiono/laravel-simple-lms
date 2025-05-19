<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollaborationRoomController;
use App\Http\Controllers\EducationRoomController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::post('login',[AuthController::class, 'authenticate'])->name('login');

// Dashboard
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

// Education Room
Route::resource('education-rooms', EducationRoomController::class);
Route::resource('collaboration-rooms', CollaborationRoomController::class);
Route::post('collaboration-rooms/store-group/{collaboration_room}', [CollaborationRoomController::class, 'storeGroup'])->name('collaboration-rooms.store-group');
Route::get('collaboration-rooms/groups/{group}', [CollaborationRoomController::class, 'showGroup'])->name('collaboration-rooms.groups');
Route::delete('collaboration-rooms/groups/{group}', [CollaborationRoomController::class, 'destroyGroup'])->name('collaboration-rooms.destroy-group');

// Submission
Route::resource('submissions', SubmissionController::class);

// Users
Route::resource('users', UserController::class);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

