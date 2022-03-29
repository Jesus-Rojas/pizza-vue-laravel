<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PizzaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nombre' => 'required',
            'stock' => 'required',
            'precio' => 'required',
            'ingredientes' => 'required',
        ];

        if (in_array($this->method(), ['POST'])) {
            $rules['imagen'] = 'required|mimes:jpeg,png';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'imagen.required' => 'La imagen es requerida.',
            'imagen.mimes' => 'La imagen debe ser de tipo (jpeg|png).',
            'nombre.required' => 'El nombre es requerido.',
            'stock.required' => 'El stock es requerido.',
            'precio.required' => 'El precio es requerido.',
            'ingredientes.required' => 'El campo ingredientes es requerido.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()->first()], 422);
        throw new ValidationException($validator, $response);
    }
}
