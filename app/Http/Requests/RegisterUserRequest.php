<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El correo es requerido.',
            'name.required' => 'El nombre es requerido.',
            'password.required' => 'La contraseña es requerida.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()->first()], 422);
        throw new ValidationException($validator, $response);
    }
}
