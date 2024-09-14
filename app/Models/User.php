<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ladder\HasRoles;
use App\Models\UserDetail;
use App\Models\RekamMedis;
use App\Models\DailyLog;
use App\Models\MonthlyLogModel;
use App\Models\NutritionLog;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // relationally of user with user detail
    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    // relationally of user with rekam medis
    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class);
    }

    // relationally of user with daily log  
    public function dailyLog()
    {
        return $this->hasMany(DailyLog::class);
    }

    // relationally of user with monthly log
    public function monthlyLog()
    {
        return $this->hasMany(MonthlyLogModel::class);
    }

    // relationally of user with nutrition log
    public function nutritionLog()
    {
        return $this->hasMany(NutritionLog::class);
    }
}
