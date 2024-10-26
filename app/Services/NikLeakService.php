<?php
namespace App\Services;

use App\Models\Ktp;

class NikLeakService
{
    protected $Ktp;

    public function __construct(Ktp $Ktp)
    {
        $this->Ktp = $Ktp;
    }

    public function checkNik($nik)
    {
        $data = $this->Ktp->where('nomor_ktp', $nik)->first();

        if ($data) {
            return $this->censorData($data->toArray());
        }

        return null;
    }

    protected function censorData(array $data)
    {
        if (isset($data['nama_pemilik'])) {
            $data['nama_pemilik'] = $this->censorName($data['nama_pemilik']);
        }

        if (isset($data['alamat'])) {
            $data['alamat'] = $this->censorString($data['alamat'], 3, 3);
        }

        if (isset($data['agama'])) {
            $data['agama'] = $this->censorString($data['agama'], 2, 2);
        }

        if (isset($data['pekerjaan'])) {
            $data['pekerjaan'] = $this->censorString($data['pekerjaan'], 2, 2);
        }

        if (isset($data['kewarganegaraan'])) {
            $data['kewarganegaraan'] = $this->censorString($data['kewarganegaraan'], 2, 2);
        }

        if (isset($data['kk_id'])) {
            $data['kk_id'] = $this->censorString($data['kk_id'], 2, 2);
        }

        return $data;
    }

    protected function censorName($name)
    {
        if (strlen($name) <= 2) {
            return str_repeat('x', strlen($name)); 
        }
        return substr($name, 0, 1) . str_repeat('x', strlen($name) - 2) . substr($name, -1);
    }

    protected function censorString($string, $start, $length)
    {
        if (strlen($string) <= $start + $length) {
            return str_repeat('x', strlen($string)); 
        }
        return substr($string, 0, $start) . str_repeat('x', $length) . substr($string, $start + $length);
    }
}