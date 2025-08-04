<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cartitems' => ['required' , 'array' , 'min:1'],
            'cartitems.*.id' => ['required' ,'integer'],
            'cartitems.*.productId' => ['required' ,'integer'],
            'cartitems.*.optionId' => ['required' ,'integer'],
            'cartitems.*.title' => ['required' ,'string'],
            'cartitems.*.option_title' => ['required' ,'string'],
            'cartitems.*.price' => ['required' ,'numeric'],
            'cartitems.*.quantity' => ['required' ,'integer' , 'min:1'],
            'cartitems.*.total_price' => ['required' ,'numeric'],
            'totalsumprice' => ['required' , 'numeric' , 'min:0'],
            'payment_method' => ['required' , 'in:cash']

        ];
    }
}
