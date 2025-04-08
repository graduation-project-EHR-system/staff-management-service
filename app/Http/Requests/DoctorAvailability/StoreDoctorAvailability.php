<?php

namespace App\Http\Requests\DoctorAvailability;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorAvailability extends FormRequest
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
            'clinic_id' => ['required', 'exists:clinics,id'],
            'date' => ['required', 'date'],
            'from' => ['required', 'date_format:H:i', 'before:to'],
            'to' => ['required', 'date_format:H:i', 'after:from'],
        ];
    }
}

