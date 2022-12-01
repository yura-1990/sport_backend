<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fillial extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function training(){
        return $this->hasMany(Training::class);
    }

}
