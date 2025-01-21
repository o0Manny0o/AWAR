<?php

use App\Http\Resources\AppStatsCollection;
use App\Models\Organisation;

Route::get('/stats', function () {
    Organisation::$withoutAppends = true;
    return new AppStatsCollection(Organisation::select(['name'])->get());
});
