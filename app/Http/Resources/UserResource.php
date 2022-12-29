<?php

namespace App\Http\Resources;

use App\Models\CheckUser;
use App\Models\PortfolioUser;
use App\Models\StatisticUser;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'login'=>$this->login,
            'role_id'=>$this->role_id,
            'pasport_id'=>$this->pasport_id,
            'fillial_id'=>$this->fillial_id,
            'check_user'=>CheckUser::where('user_id', $this->id)->first()->permission ?? null,
            'portfolio_user'=>PortfolioUser::where('user_id', $this->id)->first()->permission ?? null,
            'statistic_user'=>StatisticUser::where('user_id', $this->id)->first()->permission ?? null,
        ];
    }
}
