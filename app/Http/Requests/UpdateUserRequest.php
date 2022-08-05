<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => Rule::unique('users')->ignore($this->user),
            'phone_number' => 'required',
            'role' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,png,jpeg'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The nama field is required.',
            'email.required' => 'The email field is required.',
            'phone_number.required' => 'The no telp field is required.',
            'role.required' => 'Please select role.',
            'address.required' => 'The alamat field is required.',
        ];
    }
}
