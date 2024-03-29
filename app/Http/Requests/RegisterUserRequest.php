<?php

namespace App\Http\Requests;

use App\Models\TimeManagment;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'login' => 'required|string',
            'password' => 'required|string',
            'fillial_id'=>'required'
        ];
    }
}
