<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
                    'name' => 'required|min:3|max:255|unique:services',
                    'price' => 'required|numeric|min:1'
                ];
                break;
            
            case 'PUT':
                return [
                    'name' => 'required|min:3|max:255|unique:services,name,'. $this->route('service')->id,
                    'price' => 'required|numeric|min:1'
                ];
                break;
            
            default:
                # code...
                break;
        }
    }
}
