<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Ktp extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'ktp';
    protected $fillable = [
        'name',
        'email',
        'password', 
        'nomor_ktp',
        'nama_pemilik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'pekerjaan',
        'kewarganegaraan',
        'kk_id',
    ];


}
