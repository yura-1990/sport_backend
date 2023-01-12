<?php

namespace App\Http\Requests;

use App\Models\TimeManagment;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StorePosportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $timeManagment = TimeManagment::get()->last();

        $dayDate = Carbon::createFromFormat('Y-m-d', $timeManagment->day_from);
        $toDate = Carbon::createFromFormat('Y-m-d', $timeManagment->day_to);

        $check = Carbon::now()->between($dayDate, $toDate);

        return $check;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pnfl'=>'required',
            'pasport_seria'=>'required',
            'pasport_seria_code'=>'required',
        ];
    }
}
