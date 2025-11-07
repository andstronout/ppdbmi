<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Murid extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nik',
        'npsn',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ayah',
        'nama_ibu',
        'no_whatsapp',
        'kartu_keluarga',
        'akte',
        'tahun_masuk',
        'status',
        'catatan'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dataOrtu()
    {
        return $this->hasOne(DataOrtu::class, 'murid_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'murid_id');
    }
}
