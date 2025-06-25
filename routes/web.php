<?php

use App\Http\Middleware\UserRoles;
use App\Http\Controllers\APIWilayah;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\Admin\RoomControler;
use App\Http\Controllers\AllVillageController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\VillageController;
use App\Http\Controllers\Admin\HomestayController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\FE\MundukTourismController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\RoomGalleryController;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Admin\ContactVillageController;
use App\Http\Controllers\Admin\GalleryVillageController;
use App\Http\Controllers\Admin\TransportationController;
use App\Http\Controllers\Admin\DestinationPriceController;
use App\Http\Controllers\Admin\DestinationGalleryController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Booking\BookAccomodationController;
use App\Http\Controllers\Booking\BookDestinationController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Booking\BookTourController;
use App\Http\Controllers\Booking\TransactionController;

Route::middleware(['auth'])->get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticatedController::class, 'login'])->name('login.index');
Route::post('/login', [AuthenticatedController::class, 'store'])->name('login');
Route::post('logout', [AuthenticatedController::class, 'logout'])->name('logout');

// permission view dashboard
Route::middleware(['auth', 'permission:view-dashboard'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

//permission manage semua desa
Route::middleware(['auth', 'permission:manage-all-village'])->group(function () {
    Route::get('/desa', function () {
        return view('admin.village');
    })->name('village');
});

//permission manage desa
Route::middleware(['auth', 'permission:manage-village'])->group(function () {
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
});

//permission manage destinasi
Route::middleware(['auth', 'permission:manage-destination'])->group(function () {
    // Lokasi Destinasi
    Route::resource('destination', DestinationController::class);
    Route::post('destination/{destination}/status', [DestinationController::class, 'updateStatus'])->name('destination.updateStatus');
    Route::get('destination/{destination}/gallery', [DestinationGalleryController::class, 'index'])->name('destination.gallery');
    Route::post('destination/{destination}/gallery/store', [DestinationGalleryController::class, 'store'])->name('destination.gallery.store');
    Route::post('destination/gallery/destroy', [DestinationGalleryController::class, 'destroy'])->name('destination.gallery.destroy');

    // Tiket Destinati
    Route::resource('ticket', DestinationPriceController::class);
});

//permission manage akomodasi
Route::middleware(['auth', 'permission:manage-accomodation'])->group(function () {
    // Homestay
    Route::resource('homestays', HomestayController::class);
    Route::post('homestays/{homestay}/status', [HomestayController::class, 'updateStatus'])->name('homestays.updateStatus');

    // Room
    Route::resource('homestay/room-type', RoomTypeController::class);
    Route::get('homestay/room-type/filter', [RoomTypeController::class, 'filter'])->name('room-type.filter');
    Route::resource('homestay/room', RoomControler::class);
    Route::post('/homestay/types', [RoomControler::class, 'getRoomTypes'])->name('homestay.roomtypes');

    // Room Galeri
    Route::get('homestay/room/{id}/gallery', [RoomGalleryController::class, 'index'])->name('room.gallery');
    Route::post('homestay/room/{id}/gallery/store', [RoomGalleryController::class, 'store'])->name('room.gallery.store');
    Route::post('homestay/room/gallery/destroy', [RoomGalleryController::class, 'destroy'])->name('room.gallery.destroy');

    // Transportation
    Route::resource('transportations', TransportationController::class);
});

//permission manage tour
Route::middleware(['auth', 'permission:manage-tour'])->group(function () {
    // Tour
    Route::resource('tours', AdminTourController::class);
    Route::post('tour/status', [AdminTourController::class, 'updateStatus'])->name('tours.updateStatus');
});

//permission manage user
Route::middleware(['auth', 'permission:manage-user'])->group(function () {
    // Manager
    Route::get('manager', [ManagerController::class, 'index'])->name('manager.index');
    Route::post('manager/store', [ManagerController::class, 'store'])->name('manager.store');
    Route::post('manager/update', [ManagerController::class, 'update'])->name('manager.update');
    Route::post('manager/delete', [ManagerController::class, 'delete'])->name('manager.delete');
});


// permission manage villages
Route::middleware(['auth', 'permission:manage-all-village'])->group(function () {
    Route::resource('villages', AllVillageController::class);
    Route::put('villages/{user}', [AllVillageController::class, 'update'])->name('update.village');
});

Route::middleware(['auth', 'permission:view-destination'])->group(function () {
    Route::get('destinations', [DestinationController::class, 'index'])->name('destinations');
});

Route::middleware(['auth', 'permission:view-accomodation'])->group(function () {
    Route::get('penginapan', [HomestayController::class, 'index'])->name('penginapan');
    Route::get('transportasi', [TransportationController::class, 'index'])->name('transportasi');
    Route::get('packages', [AdminTourController::class, 'index'])->name('packages');
});

//Route Booking
Route::get('/booking/homestay', [BookAccomodationController::class, 'homestay'])->name('homestay.booking');
Route::post('/booking/homestay', [BookAccomodationController::class, 'store'])->name('homestay.booking.store');

Route::get('/booking/destination', [BookDestinationController::class, 'destination'])->name('destination.booking');
Route::post('/booking/destination', [BookDestinationController::class, 'store'])->name('destination.booking.store');

Route::get('/booking/tour', [BookTourController::class, 'tour'])->name('tour.booking');
Route::post('/booking/tour', [BookTourController::class, 'store'])->name('tour.booking.store');


Route::get('/fetch-wilayah', [APIWilayah::class, 'run']);


// Front End Desa Wisata
Route::get('/munduk-tourism/destinations', [MundukTourismController::class, 'destination'])->name('munduk-tourism.destination');
Route::get('/munduk-tourism/destination/{slug}/detail', [MundukTourismController::class, 'detailDestination'])->name('munduk-tourism.destination.detail');


//midtrans
Route::get('/booking/pay/{code}', [BookingController::class, 'showPaymentPage'])->name('booking.payment');
Route::get('/payment/success/{booking}', [BookingController::class, 'paymentSuccess'])->name('booking.success');
