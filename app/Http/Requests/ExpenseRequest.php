<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
                    'name' => 'required|min:3|max:255|unique:expenses',
                    'description' => 'required|min:3|max:255',
                ];
                break;
            
            case 'PUT':
                return [
                    'name' => 'required|min:3|max:255|unique:expenses,name,'. $this->route('expense')->id,
                    'description' => 'required|min:3|max:255',
                ];
                break;
            
            default:
                # code...
                break;
        }
    }
}
