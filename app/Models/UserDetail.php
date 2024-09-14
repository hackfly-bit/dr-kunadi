<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'keluarga_id', 'nik', 'nama_panggilan', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'alamat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }
}
