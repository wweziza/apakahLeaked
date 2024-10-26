<?php
namespace App\Http\Controllers;

use App\Services\NikLeakService;
use Illuminate\Http\Request;

class NikCheckController extends Controller
{
    protected $nikLeakService;

    public function __construct(NikLeakService $nikLeakService)
    {
        $this->nikLeakService = $nikLeakService;
    }

    public function check(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:255',
        ]);

        $nik = $request->input('nik');

        $Ktp = $this->nikLeakService->checkNik($nik);

        if ($Ktp) {
            return response()->json([
                'found' => true,
                'data' => [
                    'name' => $Ktp['nama_pemilik'], 
                    'birthdate' => $Ktp['tanggal_lahir'], 
                    'address' => $Ktp['alamat'],
                    'gender' => $Ktp['jenis_kelamin'],
                    'religion' => $Ktp['agama'],
                    'job' => $Ktp['pekerjaan'],
                    'citizenship' => $Ktp['kewarganegaraan'],
                    'kknumber'=> $Ktp['kk_id'],
                ],
            ]);
        }

        return response()->json(['found' => false]);
    }
}