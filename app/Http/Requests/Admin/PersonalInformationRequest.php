<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Functions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonalInformationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'document_type' => 'tipo de documento',
            'document_number' => 'número de documento',
            'name' => 'nombres',
            'lastname' => 'apellidos',
            'gender' => 'género',
            'birthday' => 'fecha de nacimiento',
            'phone' => 'teléfono'
        ];
    }

    public function rules()
    {
        return [
            'document_type' => 'required',
            'document_number' => 'required',
            'name' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'phone' => 'required'
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
