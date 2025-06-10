<?php
namespace App\Http\Requests;

use App\Models\Receptionist;
use App\Rules\UniqueGlobally;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReceptionistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $receptionist = Receptionist::where('id', $this->route('receptionist'))->first();
        
        return [
            'national_id' => ['sometimes', 'required', 'string', 'max:255', new UniqueGlobally('national_id', $receptionist)],
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name'  => ['sometimes', 'required', 'string', 'max:255'],
            'email'      => ['sometimes', 'required', 'email', new UniqueGlobally('email', $receptionist)],
            'phone'      => ['sometimes', 'required', 'string', new UniqueGlobally('phone', $receptionist), 'max:255'],
            'is_active'  => ['boolean']
        ];
    }
}
