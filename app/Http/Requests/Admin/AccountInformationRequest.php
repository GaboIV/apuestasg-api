<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Functions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountInformationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'nick' => 'nombre de usuario',
            'email' => 'correo electrónico',
            'timezone' => 'zona horaria',
            'language' => 'lenguaje'
        ];
    }

    public function rules()
    {
        return [
            'nick' => 'required',
            'email' => 'required',
            'timezone' => 'required',
            'language' => 'required',
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
