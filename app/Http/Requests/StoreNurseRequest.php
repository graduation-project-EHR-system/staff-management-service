<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNurseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'national_id' => ['required', 'string', 'max:255', 'unique:nurses,national_id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:nurses,email'],
            'phone'      => ['required', 'string', 'unique:nurses,phone', 'max:255'],
            'is_active'  => ['boolean'],
            'clinic_id'  => ['required', 'exists:clinics,id'],
        ];
    }
}
