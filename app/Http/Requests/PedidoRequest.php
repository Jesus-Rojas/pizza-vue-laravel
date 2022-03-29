<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PedidoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pedido' => 'required|array',
            'pedido.*.cantidad' => 'required|numeric',
            'pedido.*.precio_unitario' => 'required|numeric',
            'pedido.*.pizzas_id' => 'required|numeric',
            'venta_total' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'pedido.required' => 'El pedido es requerido.',
            'pedido.array' => 'El pedido debe ser un array.',
            'pedido.*.cantidad.required' => 'El campo cantidad es requerida example { pedido: [{ cantidad: 1 }] }',
            'pedido.*.cantidad.numeric' => 'El campo cantidad es numerico example { pedido: [{ cantidad: 1 }] }',
            'pedido.*.precio_unitario.required' => 'El campo precio_unitario es requerida example { pedido: [{ precio_unitario: 1 }] }',
            'pedido.*.precio_unitario.numeric' => 'El campo precio_unitario es numerico example { pedido: [{ precio_unitario: 1 }] }',
            'pedido.*.pizzas_id.required' => 'El campo pizzas_id es requerida example { pedido: [{ pizzas_id: 1 }] }',
            'pedido.*.pizzas_id.numeric' => 'El campo pizzas_id es numerico example { pedido: [{ pizzas_id: 1 }] }',
            'pedido.*.pizzas_id.numeric' => 'El campo pizzas_id es numerico example { pedido: [{ pizzas_id: 1 }] }',
            'venta_total.required' => 'El campo venta_total es requerido.',
            'venta_total.numeric' => 'El campo venta_total debe ser numerico.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()->first()], 422);
        throw new ValidationException($validator, $response);
    }
}
