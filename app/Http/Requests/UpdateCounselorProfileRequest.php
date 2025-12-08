<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCounselorProfileRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'nullable|string|max:20',
            'profile_pic' => 'nullable|image|max:2048',

            // Counselor table fields:
            'education'      => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'description'    => 'required|string',
            'price_per_session' => 'required|integer|min:0',
        ];
    }
}
