<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    use HasFactory;		
    protected $fillable = ['user_id', 'tanggal', 'bb', 'tb', 'lingkar_perut', 'denyut_nadi', 'tekanan_darah', 'gula_darah_sewaktu', 'gula_darah_puasa', 'asam_urat', 'kolesterol', 'foto_bb', 'foto_lingkar_perut', 'foto_tekanan_darah', 'foto_gula_darah_sewaktu', 'foto_gula_darah_puasa', 'foto_asam_urat', 'foto_kolesterol'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
