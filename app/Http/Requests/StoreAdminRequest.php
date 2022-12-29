<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'login' => 'required|max:255',
            'password' => 'required|max:255',
            'pnfl' => 'required|integer',
            'pasport_seria' => 'required|max:3',
            'pasport_seria_code' => 'required|max:20',
            'fillial_id' => 'required|exists:fillials,id'
        ];
    }
}
