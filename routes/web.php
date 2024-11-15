<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/language/{language}', function ($language) {
    $availableLocales = array_map(fn($e) => $e['id'], config('app.available_locales'));
    if (in_array($language, $availableLocales) && $language !== App::currentLocale()) {
        Session()->put('locale', $language);
    }
    App::setLocale(Session::get('locale', App::currentLocale()));

    return redirect()->back();
})->name('language')->middleware(['universal', \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class]);

require __DIR__ . '/auth.php';
