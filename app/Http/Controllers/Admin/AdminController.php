<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\User;
use App\Country;
use App\Category;
use App\Changelog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\PersonalInformationRequest;

class AdminController extends ApiController {

    public function me()
    {
        $auth_user = Auth::user();

        $user = User::where('id', $auth_user->id)
        ->with('admin')
        ->with('roles')
        ->first();

        return $this->successResponse($user, 200);
    }

    public function updatePersonalInformation(PersonalInformationRequest $request)
    {
        $data = $request->validated();
        $auth_user = Auth::user();

        $user = Admin::where('user_id', $auth_user->id)->update($data);

        return $this->successResponse($user, 200);
    }

    public function loadCategories() {
        $categories = Category::orderBy('name', 'asc')
        					  ->get();

        return $this->successResponse([
            'categories' => $categories
        ], 200);
    }

    public function loadCountries() {
        $countries = Country::orderBy('name', 'asc')
        					  ->get();

        return $this->successResponse([
            'countries' => $countries
        ], 200);
    }

    public function loadUpdatesLeagues() {
        $updates = Category::with("leagues")
                            ->get();

        return $this->successResponse([
            'updates' => $updates
        ], 200);
    }

    public function updateCountry(Request $request, $id) {
        $data = $request->all();

        if (isset($data['flag_image_link']) && (strpos($data['flag_image_link'], 'www.flaticon') !== false) && (strpos($data['flag_image_link'], 'vstatic') !== false)) {
		    $url_data = explode("/", $data['flag_image_link']);

		    $id_link = $url_data[6];
		    $svg_link = explode("?", $url_data[7]);
		    $svg_link = $svg_link[0];

		    $data['flag_image_link'] = "https://www.flaticon.es/svg/static/icons/svg/" . $id_link . "/" . $svg_link;
		} else {
			return "chao";
		}

        // echo "https://www.flaticon.es/svg/vstatic/svg/555/555562.svg?token=exp=1617577756~hmac=51a9025a22898217b2dedb49c46c5fa8";

        // echo "https://www.flaticon.es/svg/static/icons/svg/555/555616.svg";

        $country = Country::whereId($id)
                   ->update($data);

        return $this->successResponse([
            'status' => 'success'
        ], 200);
    }
}
