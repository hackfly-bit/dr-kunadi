<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'no_rekam_medis', 'nomer_kk'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

}
