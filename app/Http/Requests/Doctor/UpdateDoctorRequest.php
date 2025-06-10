<?php

namespace App\Http\Requests\Doctor;

use App\Models\Doctor;
use App\Rules\UniqueGlobally;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
        $doctor = Doctor::where('id', $this->route('doctor'))->first();

        return [
            'national_id' => ['nullable', 'string', 'max:255', new UniqueGlobally('national_id', $doctor)],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', new UniqueGlobally('email', $doctor)],
            'phone' => ['nullable', 'string', 'max:15', new UniqueGlobally('phone', $doctor)],
            'specialization_id' => ['nullable', 'exists:specializations,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
