<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/*use Illuminate\Contracts\Auth\CanResetPassword;*/


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'password',
        'login',
        'role_id',
        'fillial_id',
        'pasport_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeIsAdmin(Builder $query)
    {
        return $query->whereHas('role', function ($query) {
            return $query->where('type', 'admin');
        });
    }

    public function directions()
    {
        return $this->belongsToMany(Direction::class, 'checks')->distinct();
    }

    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class);
    }

    public function pasport()
    {
        return $this->belongsTo(Pasport::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function fillial()
    {
        return $this->belongsTo(Fillial::class);
    }

    public function work()
    {
        return $this->hasMany(Work::class);
    }

    public function portfolioUser()
    {
        return $this->hasMany(PortfolioUser::class);
    }

    public function statisticUser()
    {
        return $this->hasMany(StatisticUser::class);
    }

    public function training()
    {
        return $this->hasMany(Training::class);
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }

    public function userPdf()
    {
        return $this->hasMany(UserPdf::class);
    }

    public function check()
    {
        return $this->hasMany(Check::class);
    }

    public function allScore()
    {
        return $this->hasMany(AllScore::class);
    }

    public function checkUser()
    {
        return $this->hasMany(CheckUser::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
