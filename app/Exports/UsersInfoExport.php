<?php

namespace App\Exports;

use App\Http\Traits\LocaleTrait;
use App\Models\AllScore;
use App\Models\Avatar;
use App\Models\Check;
use App\Models\Education;
use App\Models\Pasport;
use App\Models\PersonalInfo;
use App\Models\Region;
use App\Models\Training;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UsersInfoExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    protected $direction_id;

    public function __construct($direction_id)
        {
        $this->direction_id = $direction_id;
    }

    public function view(): View
    {
        $direction_user = Check::where('direction_id',$this->direction_id)->get();

        $data = [];
        $passport_info = [];

        foreach ($direction_user as $user){
            $passport_info['pnfl'] = Pasport::where('id', $user->user->pasport_id)->first()->pnfl ?? null;
            $passport_info['pasport_seria'] = Pasport::where('id', $user->user->pasport_id)->first()->pasport_seria ?? null;
            $passport_info['pasport_seria_code'] = Pasport::where('id', $user->user->pasport_id)->first()->pasport_seria_code ?? null;
            $passport_info['user_name']=PersonalInfo::where('user_id', $user->user->id)->first()->full_name ?? null;
            $passport_info['gender']=PersonalInfo::where('user_id', $user->user->id)->first()->gender ?? null;
            $passport_info['email']=PersonalInfo::where('user_id', $user->user->id)->first()->email ?? null;
            $passport_info['nationality']=PersonalInfo::where('user_id', $user->user->id)->first()->nationality ?? null;
            $passport_info['birth_date']=PersonalInfo::where('user_id', $user->user->id)->first()->birth_date ?? null;
            $passport_info['phone']=PersonalInfo::where('user_id', $user->user->id)->first()->phone ?? null;
            $passport_info['all_score']=AllScore::where('user_id', $user->user->id)->first()->all_score ?? null;
            $passport_info['training_direction']=Training::where('user_id', $user->user->id)->first()->direction ?? null;
            $passport_info['training_date_end']=Training::where('user_id', $user->user->id)->first()->date_end ?? null;
            $passport_info['training_date_start']=Training::where('user_id', $user->user->id)->first()->date_start ?? null;
            $passport_info['user_id']=$user->user->name ?? null;
            $data[] = $passport_info;
        }

        return view('exports.userInfo', ['datas' => $data]);

    }
}
