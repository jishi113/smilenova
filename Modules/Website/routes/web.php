<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'home'])->name('home');