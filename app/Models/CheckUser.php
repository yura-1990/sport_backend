<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckUser extends Model
{
    use HasFactory;
    protected $fillable=['user_id','permission','message',];

    public function user(){
        return $this->belongsToMany(User::class);
    }
}
