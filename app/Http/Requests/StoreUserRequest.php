<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|unique:users',
            'phone_number' => 'required',
            'password' => 'required',
            'role' => 'required',
            'address' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The nama field is required.',
            'email.required' => 'The email field is required.',
            'phone_number.required' => 'The no telp. field is required.',
            'password.required' => 'The password field is required.',
            'role.required' => 'Please select role.',
            'address.required' => 'The alamat field is required.',
            'image.required' => 'The image field is required.',
        ];
    }
}
