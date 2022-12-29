<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllScore extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='all_scores';

    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function direction(){
        return $this->belongsToMany(Direction::class);
    }
}
