<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganisationController;

Route::resource('organisation', OrganisationController::class)->middleware(['auth', 'verified']);
