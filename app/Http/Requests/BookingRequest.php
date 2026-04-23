<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BookingRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('notes')) {
            $this->merge([
                'notes' => trim((string) $this->input('notes')),
            ]);
        }

        if (! $this->has('payment_scheme')) {
            $this->merge([
                'payment_scheme' => 'full',
            ]);
        }
    }

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
            'schedule_id' => 'required|exists:schedules,id',
            'second_schedule_id' => 'nullable|exists:schedules,id',
            'consultation_type' => 'required|in:online,offline',
            'payment_scheme' => 'required|in:full,dp',
            'notes' => 'required|string',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (
                    $this->input('consultation_type') === 'online' &&
                    $this->input('payment_scheme') !== 'full'
                ) {
                    $validator->errors()->add(
                        'payment_scheme',
                        'Konsultasi online harus dibayar lunas.',
                    );
                }
            },
        ];
    }
}
