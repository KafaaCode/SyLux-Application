<?php

use App\Http\Controllers\DeployController;
use App\Http\Middleware\VerifyDeploySecret;
use Illuminate\Support\Facades\Route;

Route::middleware(['deploy.secret', 'throttle:10,1'])
    ->prefix('_deploy')
    ->group(function () {
        Route::get('{token}', [DeployController::class, 'index'])->name('deploy.index');
        Route::post('{token}/run', [DeployController::class, 'run'])->name('deploy.run');
    });
