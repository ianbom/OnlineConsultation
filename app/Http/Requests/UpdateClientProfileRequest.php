<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateClientProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $userId = Auth::id();

        return [
        'name'              => 'nullable|string|max:255',
        'email'             => 'nullable|email|unique:users,email,' . $userId,
        'phone'             => 'nullable|string|max:20',
        'profile_pic'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

        // Password optional - only validated if provided
        'password'          => 'nullable|min:8|confirmed',
    ];
    }

    public function messages(){
    return [
        'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        'password.min'       => 'Password minimal 8 karakter.',
    ];
        }
}
