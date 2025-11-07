<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'murid_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'bukti_bayar', 
        'status_bayar', 
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id');
    }
}
