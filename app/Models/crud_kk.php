<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class crud_kk extends Model
{
    use HasFactory;

    protected $table = 'kk';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nomor_kk',
        'nama_kepala_keluarga',
        'alamat'
    ];

    protected $casts = [
        'tanggal_dibuat' => 'datetime'
    ];

    public function ktps()
    {
        return $this->hasMany(crud_ktp::class, 'kk_id', 'id');
    }
}
