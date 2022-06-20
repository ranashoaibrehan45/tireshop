<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TireSizeRequest extends FormRequest
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
                    'name' => 'required|min:3|max:255|unique:tire_sizes',
                ];
                break;
            
            case 'PUT':
                return [
                    'name' => 'required|min:3|max:255|unique:tire_sizes,name,'. $this->route('tire_size')->id,
                ];
                break;
            
            default:
                # code...
                break;
        }
    }
}
