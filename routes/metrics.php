<?php

use App\Http\Controllers\Admin\V1\Metrics\MetricsController;
use Illuminate\Support\Facades\Route;

Route::get('/metrics', [MetricsController::class, 'index']);
