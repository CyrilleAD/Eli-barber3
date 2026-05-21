<?php

use App\Http\Controllers\AdminLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.landing');
})->name('client.landing');

Route::get('/admin/login', [AdminLoginController::class, 'show'])->name('admin.login.show');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.login');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.login.logout');

Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
