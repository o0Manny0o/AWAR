<?php

use App\Http\Controllers\Organisation\OrganisationApplicationController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'organisations', 'as' => 'organisations.'], function () {
    Route::resource('applications', OrganisationApplicationController::class)
        ->middleware(['auth', 'verified']);
    Route::patch('/applications/{application}/restore', [OrganisationApplicationController::class, 'restore'])->name("applications.restore");
});
