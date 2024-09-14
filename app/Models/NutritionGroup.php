<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionGroup extends Model
{
    use HasFactory;

    // protected $fillable = ['name', 'description', 'active'];    
    protected $guarded = ['id'];

    public function nutritionLogs()
    {
        return $this->hasMany(NutritionLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
