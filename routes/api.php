<?php

use App\Http\Controllers\ConvertController;
use Illuminate\Support\Facades\Route;

Route::post('/convert', ConvertController::class);
