<?php

namespace App\Http\Requests\Specialization;

use App\Enums\SpecializationColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSpecializationRequest extends FormRequest
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
            'name' => ['required' , 'string' , 'unique:specializations,name' , 'min:3' , 'max:50'],
            'description' => ['required' , 'string', 'min:3' , 'max:255'],
            'color' => ['required', 'string', Rule::enum(SpecializationColor::class)]
        ];
    }
}
