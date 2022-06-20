<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TireRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|min:1',
            'purchase_price' => 'required|numeric|min:500',
        ];
    }
}
