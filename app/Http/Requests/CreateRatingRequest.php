<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'commentar' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'booking_id.required' => 'Booking ID wajib diisi.',
            'booking_id.exists' => 'Booking tidak ditemukan.',
            'rating.required' => 'Rating wajib diisi.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'commentar.max' => 'Komentar maksimal 1000 karakter.',
        ];
    }
}
