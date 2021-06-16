<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CountryController extends ApiController
{
    public function index(Request $request)
    {
        if (request()->page) {
            $countries = Country::filterByColumns($request->all())
            ->orderBy('id', 'desc')->paginate(20);
        } else {
            $countries = Country::all();
        }

        return $this->successResponse([
            'countries' => $countries
        ], 200);
    }
}
