<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'config'], function () {
    // PARAMETERS CONFIGURATION
    Route::get('', 'General\ConfigurationController@index');

    // LOCATION
    Route::get('/states', 'General\ConfigurationController@indexStates');
    // LOCATION - STATES
    Route::get('/states/{id}', 'General\ConfigurationController@indexState');
    Route::get('/states/{id}/cities', 'General\ConfigurationController@indexCitiesByState');
    // LOCATION - CITIES
    Route::get('/cities/{id}', 'General\ConfigurationController@indexCity');
    Route::get('/cities/{id}/parishes', 'General\ConfigurationController@indexParishesByCity');
    // LOCATION - PARISHES
    Route::get('/parishes/{id}', 'General\ConfigurationController@indexParish');
});

// AUTH
Route::group(['prefix' => 'auth'], function () {
    // LOGIN
    Route::post('/login', 'Auth\LoginController@loginAdmin');
});

Route::group(['middleware' => 'auth:api'], function () {
    // GET USER AUTH
    Route::get('/me', 'Admin\AdminController@me');

    Route::put('/me/personal-information', 'Admin\AdminController@updatePersonalInformation');
});
