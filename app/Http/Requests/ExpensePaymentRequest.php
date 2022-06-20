<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensePaymentRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'expense_id' => 'required|gt:0',
                    'amount' => 'required|numeric|gt:0',
                    'paid_at' => 'required|date'
                ];
                break;
            
            case 'PUT':
                return [
                    'expense_id' => 'required|gt:0',
                    'amount' => 'required|numeric|gt:0',
                    'paid_at' => 'required|date'
                ];
                break;
            
            default:
                # code...
                break;
        }
    }
}
