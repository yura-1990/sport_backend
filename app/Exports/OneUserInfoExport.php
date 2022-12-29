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
use App\Models\User;
use App\Models\Work;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OneUserInfoExport implements FromView
{
    protected $user_id;
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function view(): View
    {
        $user = User::find($this->user_id);
//        $region_id = Work::where('user_id', $this->user_id)->first()->region_id ?? null;
//        $training_id = Training::where('user_id', $this->user_id)->first()->region_id ?? null;

        $passport_info['pnfl'] = Pasport::where('id', $user->pasport_id)->first()->pnfl ?? null;
        $passport_info['pasport_seria'] = Pasport::where('id', $user->pasport_id)->first()->pasport_seria ?? null;
        $passport_info['pasport_seria_code'] = Pasport::where('id', $user->pasport_id)->first()->pasport_seria_code ?? null ;
        $passport_info['user_name']=PersonalInfo::where('user_id', $this->user_id)->first()->full_name ?? null;
        $passport_info['email']=PersonalInfo::where('user_id', $this->user_id)->first()->email ?? null;
        $passport_info['nationality']=PersonalInfo::where('user_id', $this->user_id)->first()->nationality ?? null;
        $passport_info['birth_date']=PersonalInfo::where('user_id', $this->user_id)->first()->birth_date ?? null;
        $passport_info['phone']=PersonalInfo::where('user_id', $this->user_id)->first()->phone ?? null;
        $passport_info['user_id']=$user_id ?? null;
        $passport_info['gender']=PersonalInfo::where('user_id', $this->user_id)->first()->gender ?? null;
        $passport_info['avatar']=Avatar::where('user_id', $this->user_id)->first()->photo ?? null;
        $passport_info['all_score']=AllScore::where('user_id', $this->user_id)->first()->all_score ?? null;
        $passport_info['training_direction']=Training::where('user_id', $this->user_id)->first()->direction ?? null;
        $passport_info['training_date_end']=Training::where('user_id', $this->user_id)->first()->date_end ?? null;
        $passport_info['training_date_start']=Training::where('user_id', $this->user_id)->first()->date_start ?? null;
        $passport_info['education_specialization']=Education::select('specialization')->where('user_id', $this->user_id)->first()->specialization ?? null;
        $passport_info['education_name']=Education::select('education_name')->where('user_id', $this->user_id)->first()->education_name ?? null;
//        $passport_info['work_region']= Region::where('id', $region_id)->select(LocaleTrait::convert('name'))->first() ?? null;
//        $passport_info['training_region']= Region::where('id', $training_id)->select(LocaleTrait::convert('name'))->first() ?? null;
//        $passport_info['education']= Education::where('user_id', $this->user_id)->get() ?? null;
        $passport_info['work_name']= Work::where('user_id', $this->user_id)->first()->work_name ?? null;
        $passport_info['work_place']= Work::where('user_id', $this->user_id)->first()->work_place ?? null;
        $passport_info['training_direction']= Training::where('user_id', $this->user_id)->first()->direction ?? null;


        $data[] = $passport_info;
        return view('exports.oneUserInfo', ['datas' => $data]);
    }
}
