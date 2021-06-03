<?php

namespace App\Http\Requests\Admin\Me;

use App\Helpers\Functions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonalAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'state_id' => 'estado',
            'city_id' => 'ciudad',
            'parish_id' => 'parroquia',
            'address' => 'dirección'
        ];
    }

    public function rules()
    {
        return [
            'state_id' => 'required',
            'city_id' => 'required',
            'parish_id' => 'required',
            'address' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw  new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => Functions::getValidatorMessage($validator),
        ], 422));
    }
}
