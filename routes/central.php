<?php

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('landing-page');

Route::get('/about', function () {
    return Inertia::render('Welcome');
})->name('about');

Route::get('/pricing', function () {
    return Inertia::render('Welcome');
})->name('pricing');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
