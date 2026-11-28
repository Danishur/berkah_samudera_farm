<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\SiteMaintenance;
use App\Http\Middleware\TrackVisit;
use Illuminate\Support\Facades\Route;

// Halaman publik: ditutup saat mode perawatan, dan kunjungannya dicatat untuk statistik.
Route::middleware([SiteMaintenance::class, TrackVisit::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/kambing', [HomeController::class, 'goats'])->name('goats.index');
    Route::get('/kambing/{goat:code}', [HomeController::class, 'show'])->name('goats.show');
    Route::get('/galeri', [PageController::class, 'gallery'])->name('gallery');
    Route::get('/panduan', [PageController::class, 'guide'])->name('guide');
    Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
});

Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->middleware(SiteMaintenance::class)->name('sitemap');
