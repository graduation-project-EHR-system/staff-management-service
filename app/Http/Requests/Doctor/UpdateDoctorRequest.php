<?php

namespace App\Http\Requests\Doctor;

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
        return [
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'unique:doctors,email,' . ($this->route('doctor') && is_object($this->route('doctor')) ? $this->route('doctor')->id : '')],
            'phone' => ['nullable', 'string', 'max:15', 'unique:doctors,phone,' . ($this->route('doctor') && is_object($this->route('doctor')) ? $this->route('doctor')->id : '')],
            'specialization_id' => ['nullable', 'exists:specializations,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
