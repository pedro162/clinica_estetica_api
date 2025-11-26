<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\V1\Metrics\MetricsController;

Route::get('/metrics', [MetricsController::class, 'index']);
