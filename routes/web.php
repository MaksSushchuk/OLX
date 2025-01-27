<?php

use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;

Route::get('/subscribe', action: SubscribeController::class);
