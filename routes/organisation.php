<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organisation\OrganisationController;

Route::resource('organisations', OrganisationController::class)->middleware(['auth', 'verified']);
