<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    public $table="trainings";
    protected $fillable=['region_id','user_id','fillial_id','direction','date_start','date_end'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function fillial(){
        return $this->belongsTo(Fillial::class);
    }
}
