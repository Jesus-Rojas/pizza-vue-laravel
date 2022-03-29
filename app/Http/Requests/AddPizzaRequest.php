<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AddPizzaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'imagen' => 'required|file',
            'stock' => 'required|string',
            'precio' => 'required|string',
            'ingredientes' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.string' => 'El nombre debe ser string.',
            'imagen.required' => 'La imagen es requerida.',
            'imagen.file' => 'La imagen debe ser de tipo file.',
            'stock.required' => 'El stock es requerido.',
            'stock.string' => 'El stock debe ser string.',
            'precio.required' => 'El precio es requerido.',
            'precio.string' => 'El precio debe ser string.',
            'ingredientes.required' => 'El campo ingredientes es requerido.',
            'ingredientes.string' => 'El campo ingredientes debe ser string.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()->first()], 422);
        throw new ValidationException($validator, $response);
    }
}
