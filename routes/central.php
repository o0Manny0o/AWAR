<?php

use App\Http\AppInertia;

Route::get('/', function () {
    return AppInertia::render('Welcome');
})->name('landing-page');

Route::get('/about', function () {
    return AppInertia::render('Welcome');
})->name('about');

Route::get('/pricing', function () {
    return AppInertia::render('Welcome');
})->name('pricing');

Route::get('/dashboard', function () {
    return AppInertia::render('Dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
