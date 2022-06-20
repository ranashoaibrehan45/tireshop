<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Log;

class RegisterFormRequest extends FormRequest
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
        Log::info("rules");
        Log::info($this->route('user'));
        switch ($this->method()) {
            case 'POST':
                return [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'username' => 'required|min:3|max:255|unique:users',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                ];
                break;
            
            case 'PUT':
                return [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'username' => 'required|min:3|max:255|unique:users,username,' . $this->route('user'),
                    'email' => 'required|email|unique:users,email,' . $this->route('user'),
                ];
                break;
            
            default:
                # code...
                break;
        }
    }
}
