<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceptionistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $receptionistId = $this->route('id') ?? $this->route('receptionist');
        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name'  => ['sometimes', 'required', 'string', 'max:255'],
            'email'      => ['sometimes', 'required', 'email', 'unique:receptionists,email,' . $receptionistId . ',id'],
            'phone'      => ['sometimes', 'required', 'string', 'unique:receptionists,phone,' . $receptionistId . ',id', 'max:255'],
            'is_active'  => ['boolean']
        ];
    }
}
