<?php
namespace App\Http\Requests;

use App\Models\Nurse;
use App\Rules\UniqueGlobally;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNurseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $nurse = Nurse::where('id', $this->route('nurse'))->first();
        
        return [
            'national_id' => ['sometimes', 'required', 'string', 'max:255', new UniqueGlobally('national_id', $nurse)],
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name'  => ['sometimes', 'required', 'string', 'max:255'],
            'email'      => ['sometimes', 'required', 'email', new UniqueGlobally('email', $nurse)],
            'phone'      => ['sometimes', 'required', 'string', new UniqueGlobally('phone', $nurse), 'max:255'],
            'is_active'  => ['boolean'],
        ];
    }
}
