<?php

use Illuminate\Support\Facades\Route;

// AUTH
Route::group(['prefix' => 'auth'], function () {
    // LOGIN
    Route::post('/login', 'Auth\LoginController@loginAdmin');
});

Route::group(['middleware' => 'auth:api'], function () {
    // GET USER AUTH
    Route::get('/me', 'Admin\AdminController@me');
});
