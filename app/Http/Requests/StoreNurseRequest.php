<?php
namespace App\Http\Requests;

use App\Rules\UniqueGlobally;
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
            'email'      => ['required', 'email', new UniqueGlobally('email')],
            'phone'      => ['required', 'string', new UniqueGlobally('phone'), 'max:255'],
            'is_active'  => ['boolean'],
            'clinic_id'  => ['required', 'exists:clinics,id'],
        ];
    }
}
