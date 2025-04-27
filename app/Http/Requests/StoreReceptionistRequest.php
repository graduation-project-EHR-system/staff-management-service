<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceptionistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:receptionists,email'],
            'phone'      => ['required', 'string', 'unique:receptionists,phone', 'max:255'],
            'is_active'  => ['boolean'],
        ];
    }
}
