<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::group(['as' => 'frontend.', 'namespace' => 'Frontend'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

});
