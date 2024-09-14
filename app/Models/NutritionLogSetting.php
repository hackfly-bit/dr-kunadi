<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionLogSetting extends Model
{
    use HasFactory;

    protected $fillable = ['activity', 'description', 'active'];
}
