<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class DirectionResource extends JsonResource
{
    protected $fillial_id;
    public function __construct($resource, $fillial_id)
    {
        parent::__construct($resource);
        $this->fillial_id = $fillial_id;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data=[];
        foreach ($this->users as $user){
            if ($user->fillial_id == $this->fillial_id){
                $data[]=$user;
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title_uz ?? $this->title_ru ?? $this->title_en,
            'users'=> UserResource::collection($data) ?? null,
        ];
    }
}
