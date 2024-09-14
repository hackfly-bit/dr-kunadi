<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'time', 'food', 'calories', 'protein', 'fat', 'carbohydrate', 'fiber', 'sugar', 'cholesterol', 'sodium', 'potassium', 'calcium', 'iron', 'vitamin_a', 'vitamin_c', 'vitamin_d', 'vitamin_b6', 'vitamin_b12', 'magnesium', 'zinc', 'water', 'caffeine', 'alcohol', 'note'];
}
