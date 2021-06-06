<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\ApiController;

class CountryController extends ApiController
{
    public function index()
    {
        $countries = Country::all();

        return $this->successResponse([
            'countries' => $countries
        ], 200);
    }
}
