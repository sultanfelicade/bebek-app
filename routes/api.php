<?php

use App\Http\Controllers\Api\SyncController;
use Illuminate\Support\Facades\Route;

Route::get('/sync/master', [SyncController::class, 'master']);
Route::post('/sync/push', [SyncController::class, 'push']);
