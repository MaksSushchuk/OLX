<?php

use App\Services\PriceTracker\PriceTrackerService;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    $service = app(PriceTrackerService::class);

    $service->subscribe('', 'test@gmail.com');
});
