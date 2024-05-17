<?php

use App\Http\Controllers\Admin\ContactVillage;
use App\Http\Controllers\Admin\ContactVillageController;
use App\Http\Controllers\Admin\GalleryVillageController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\VillageController;
use App\Http\Controllers\APIWilayah;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Middleware\UserRoles;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticatedController::class, 'login'])->name('login');
Route::post('/login', [AuthenticatedController::class, 'store'])->name('login');
Route::post('logout', [AuthenticatedController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin-desa'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    // Info Desa
    Route::get('/info-desa', [VillageController::class, 'index'])->name('desa.info');
    Route::post('/info-desa/store', [VillageController::class, 'store'])->name('store.info-desa');

    // Contact
    Route::get('/contact-desa', [ContactVillageController::class, 'index'])->name('desa.contact');
    Route::post('/contact-desa/store', [ContactVillageController::class, 'store'])->name('store.contact-desa');
    Route::post('/contact-desa/update', [ContactVillageController::class, 'update'])->name('update.contact-desa');
    Route::post('/contact-desa/delete', [ContactVillageController::class, 'delete'])->name('delete.contact-desa');

    // Gallery
    Route::get('/gallery-desa', [GalleryVillageController::class, 'index'])->name('desa.gallery');
    Route::post('/gallery-desa/store', [GalleryVillageController::class, 'store'])->name('store.gallery-desa');
    Route::post('/gallery-desa/delete', [GalleryVillageController::class, 'delete'])->name('delete.gallery-desa');

    // Manager
    Route::get('manager', [ManagerController::class, 'index'])->name('manager.index');
    Route::post('manager/store', [ManagerController::class, 'store'])->name('manager.store');
    Route::post('manager/update', [ManagerController::class, 'update'])->name('manager.update');
    Route::post('manager/delete', [ManagerController::class, 'delete'])->name('manager.delete');
});
