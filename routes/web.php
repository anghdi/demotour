<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/tours', 'pages::tours.index')->name('tours.index');
Route::livewire('/tours/{tour}', 'pages::tours.show')->name('tours.show');

Route::prefix('booking')->name('booking.')->group(function (): void {
    Route::livewire('/details', 'pages::booking.details')->name('details');
    Route::livewire('/checkout', 'pages::booking.checkout')->name('checkout');
    Route::livewire('/payment', 'pages::booking.payment')->name('payment');
    Route::livewire('/success', 'pages::booking.success')->name('success');
});

Route::livewire('/admin/login', 'pages::admin.login')->name('admin.login');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function (): void {
    Route::livewire('/', 'pages::admin.dashboard')->name('dashboard');
    Route::livewire('/bookings', 'pages::admin.bookings.index')->name('bookings.index');
    Route::livewire('/bookings/{booking}', 'pages::admin.bookings.show')->name('bookings.show');
});
