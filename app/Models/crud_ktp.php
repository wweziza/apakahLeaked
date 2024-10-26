<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class crud_ktp extends Model
{
    use HasFactory;

    protected $table = 'ktp';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nomor_ktp',
        'nama_pemilik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'pekerjaan',
        'kewarganegaraan',
        'kk_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    public function kk()
    {
        return $this->belongsTo(crud_kk::class, 'kk_id', 'id');
    }
}