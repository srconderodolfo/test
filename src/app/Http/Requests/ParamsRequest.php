<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParamsRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'  => 'required',

        ];
    }

    public function messages()
    {
        return [
            'image.required'     => 'Selecione a imagem.'
        ];
    }
}
