<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataOrtu extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ortu';

    protected $fillable = [
        'murid_id',
        'nama_ayah',
        'nama_ibu',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id');
    }
}
