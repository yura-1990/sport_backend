<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'is_read'];

    public function scopeNewOnly(Builder $builder)
    {
        return $builder->where('is_read', false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
