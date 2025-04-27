<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNurseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $nurseId = $this->route('id') ?? $this->route('nurse');
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name'  => 'sometimes|required|string|max:255',
            'email'      => 'sometimes|required|email|unique:nurses,email,' . $nurseId . ',id',
            'phone'      => 'sometimes|required|string|unique:nurses,phone,' . $nurseId . ',id|max:255',
            'is_active'  => 'boolean',
        ];
    }
}
