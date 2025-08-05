<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Agent\AgentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('welcome');
    // return "Houzez Laravel API's";
});
// routes/web.php
Route::get('/search', [AgentController::class, 'autoSearch'])->name('search.auto');
