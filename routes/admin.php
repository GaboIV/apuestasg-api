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

    Route::group(['prefix' => 'me'], function () {
        // GET USER AUTH
        Route::get('', 'Admin\AdminController@me');
        // UPDATE USER INFORMATION
        Route::put('/personal-information', 'Admin\AdminController@updatePersonalInformation');
        Route::put('/personal-address', 'Admin\AdminController@updatePersonalAddress');
        Route::put('/account-information', 'Admin\AdminController@updateAccountInformation');
        Route::put('/change-password', 'Admin\AdminController@updatePassword');
    });

    Route::group(['prefix' => 'leagues'], function () {
        Route::patch('/{id}/attach', 'Admin\LeagueController@attachNameUk');
        Route::patch('/{id}/dettach', 'Admin\LeagueController@dettachNameUk');
        Route::post('/category/country', 'Admin\LeagueController@byCategory');
        Route::post('/{id}/sync', 'Admin\LeagueController@sync');
        Route::post('/sync48', 'Admin\LeagueController@syncLeagues48');
        Route::resource('', 'Admin\LeagueController')->except([
            'create', 'edit'
        ]);
        Route::put('/{id}', 'Admin\LeagueController@update');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::resource('', 'Admin\CategoryController')->only([
            'index'
        ]);
    });

    Route::group(['prefix' => 'countries'], function () {
        Route::resource('', 'Admin\CountryController')->only([
            'index'
        ]);
    });

});
