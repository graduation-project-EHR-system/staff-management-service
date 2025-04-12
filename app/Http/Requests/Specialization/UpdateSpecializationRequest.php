<?php

namespace App\Http\Requests\Specialization;

use App\Enums\SpecializationColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecializationRequest extends FormRequest
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
            'name' => ['nullable', 'string' , 'unique:specializations,name,' . ($this->route('specialization') && is_object($this->route('specialization')) ? $this->route('specialization')->id : ''), 'min:3' , 'max:50'],
            'description' => ['nullable' , 'string', 'min:3' , 'max:255'],
            'color' => ['nullable', 'string', Rule::enum(SpecializationColor::class)]
        ];
    }
}

