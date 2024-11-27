<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


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

    return redirect()->back();
})->middleware(['universal', \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class])->name('language');

require __DIR__ . '/auth.php';
