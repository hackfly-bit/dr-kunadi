<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyLogModel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tanggal', 'hba1c', 'sgot', 'sgpt', 'd_dimer', 'ureum', 'creatinin', 'gfr', 'lainnya', 'foto'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
