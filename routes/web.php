<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.landing');
})->name('client.landing');

Route::get('/reserver', [BookingController::class, 'showBookingForm'])->name('client.book');
Route::post('/reserver', [BookingController::class, 'storeBooking'])->name('client.book.store');
Route::get('/confirmation', [BookingController::class, 'showSuccess'])->name('client.success');

Route::get('/admin/login', [AdminLoginController::class, 'show'])->name('admin.login.show');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/availabilities', [AdminDashboardController::class, 'storeAvailability'])->name('admin.availabilities.store');
    Route::delete('/admin/availabilities/{id}', [AdminDashboardController::class, 'destroyAvailability'])->name('admin.availabilities.destroy');
    Route::post('/admin/appointments/{id}/cancel', [AdminDashboardController::class, 'cancelAppointment'])->name('admin.appointments.cancel');
});