<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCounselorRequest extends FormRequest
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
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6',
            'education'         => 'required|string',
            'specialization'    => 'required|string',
            'description'       => 'required|string',
            'price_per_session' => 'required|integer|min:0',
            'profile_pic'       => 'nullable',
            'phone'             => 'nullable|string',
        ];
    }
}
