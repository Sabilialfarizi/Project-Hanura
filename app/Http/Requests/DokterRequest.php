<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'phone_number.required' => 'The phone number. field is required.',
            'password.required' => 'The password field is required.',
            'address.required' => 'The address field is required.',
        ];
    }
}
