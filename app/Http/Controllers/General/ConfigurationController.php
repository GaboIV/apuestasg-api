<?php

namespace App\Http\Controllers\General;

use App\City;
use App\State;
use App\Parish;
use App\Configuration;
use App\Http\Controllers\ApiController;

class ConfigurationController extends ApiController {
    public function __construct() {
        $this->middleware('guest');
    }

    public function index() {
        return Configuration::all();
    }

    public function indexStates() {
        return State::all();
    }

    public function indexState($id) {
        return State::where('id', $id)->with('cities.parishes')->first();
    }

    public function indexCitiesByState($id) {
        return City::where('state_id', $id)->get();
    }

    public function indexCity($id) {
        return City::where('id', $id)->with('parishes')->first();
    }

    public function indexParishesByCity($id) {
        return Parish::where('city_id', $id)->get();
    }

    public function indexParish($id) {
        return Parish::where('id', $id)->first();
    }
}
