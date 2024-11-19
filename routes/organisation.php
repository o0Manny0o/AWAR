<?php

use App\Http\Controllers\Organisation\OrganisationApplicationController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'organisations', 'as' => 'organisations.'], function () {
    Route::resource('applications', OrganisationApplicationController::class)
        ->middleware(['auth', 'verified'])
        ->missing(function (Request $request) {
            return Redirect::route('organisations.applications.index');
        });
});
