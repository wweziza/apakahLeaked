<?php

namespace App\Http\Controllers;

use App\Models\crud_kk;
use App\Models\crud_ktp;
use Illuminate\Http\Request;

class DataManagementController extends Controller
{
    public function index()
    {
        return view('data-management');
    }

    public function list()
    {
        try {
            $data = crud_ktp::with('kk')->get();
            return response()->json($data->toArray());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $term = $request->query('term');
            $data = crud_ktp::whereHas('kk', function($query) use ($term) {
                $query->where('nomor_kk', 'like', "%{$term}%");
            })->with('kk')->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = crud_ktp::with('kk')->findOrFail($id);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $ktp = crud_ktp::findOrFail($id);
            
            // Update only KTP data
            $ktp->update([
                'nomor_ktp' => $request->nomor_ktp,
                'nama_pemilik' => $request->nama_pemilik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'agama' => $request->agama,
                'pekerjaan' => $request->pekerjaan,
                'kewarganegaraan' => $request->kewarganegaraan,
            ]);
    
            return response()->json([
                'success' => true, 
                'data' => $ktp->load('kk')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            if ($request->create_kk) {
                $kk = crud_kk::create([
                    'nomor_kk' => $request->nomor_kk,
                    'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
                    'alamat' => $request->alamat_kk
                ]);
            } else {
                $kk = crud_kk::where('nomor_kk', $request->nomor_kk)->first();
                if (!$kk) {
                    return response()->json([
                        'success' => false, 
                        'error' => 'KK not found with the specified number'
                    ], 404);
                }
            }
    
            $ktp = crud_ktp::create([
                'nomor_ktp' => $request->nomor_ktp,
                'nama_pemilik' => $request->nama_pemilik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'agama' => $request->agama,
                'pekerjaan' => $request->pekerjaan,
                'kewarganegaraan' => $request->kewarganegaraan,
                'kk_id' => $kk->id
            ]);
    
            return response()->json([
                'success' => true, 
                'data' => $ktp->load('kk')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $ktp = crud_ktp::findOrFail($id);
            $ktp->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getStats()
    {
        try {
            $ktpCount = crud_ktp::count();
            $kkCount = crud_kk::count();
    
            \Log::info('Stats retrieved:', ['ktp' => $ktpCount, 'kk' => $kkCount]);
    
            return response()->json([
                'success' => true,
                'ktpCount' => $ktpCount,
                'kkCount' => $kkCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'ktpCount' => 0,
                'kkCount' => 0
            ], 500);
        }
    }
}