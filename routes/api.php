<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StandardController;

Route::prefix('/v1/')->group(function () {
	Route::get('standards', [StandardController::class, 'index'])->name('api.standards.index');
});