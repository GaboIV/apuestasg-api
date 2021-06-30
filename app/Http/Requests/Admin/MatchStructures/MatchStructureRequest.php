<?php

namespace App\Http\Requests\Admin\MatchStructures;

use App\Helpers\Functions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MatchStructureRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'category_id' => 'categoría',
            'division_name_singular' => 'nombre de sección en singular',
            'division_name_plural' => 'nombre de sección en plural',
            'annotation_name_singular' => 'puntuación en singular',
            'annotation_name_plural' => 'puntuación en plural',
            'division_number' => 'número de secciones',
            'type' => 'tipo de estructura',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'               => 'required|exists:categories,id',
            'division_name_singular'    => 'required|string',
            'division_name_plural'      => 'required|string',
            'annotation_name_singular'  => 'required|string',
            'annotation_name_plural'    => 'required|string',
            'division_number'           => 'required',
            'type'                      => 'required'
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
