<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Get all provinces
     */
    public function getProvinsi()
    {
        try {
            $provinsi = Provinsi::select('id', 'name', 'code')
                ->orderBy('name')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $provinsi
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching provinces: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kabupaten by province ID
     */
    public function getKabupaten(Request $request)
    {
        try {
            $provinsiId = $request->get('provinsi_id');
            
            if (!$provinsiId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Province ID is required'
                ], 400);
            }

            $kabupaten = Kabupaten::select('id', 'name', 'type', 'code')
                ->where('provinsi_id', $provinsiId)
                ->orderBy('name')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $kabupaten
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching regencies: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kecamatan by kabupaten ID
     */
    public function getKecamatan(Request $request)
    {
        try {
            $kabupatenId = $request->get('kabupaten_id');
            
            if (!$kabupatenId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Regency ID is required'
                ], 400);
            }

            $kecamatan = Kecamatan::select('id', 'name', 'code')
                ->where('kabupaten_id', $kabupatenId)
                ->orderBy('name')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $kecamatan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching districts: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get kelurahan by kecamatan ID
     */
    public function getKelurahan(Request $request)
    {
        try {
            $kecamatanId = $request->get('kecamatan_id');
            
            if (!$kecamatanId) {
                return response()->json([
                    'success' => false,
                    'message' => 'District ID is required'
                ], 400);
            }

            $kelurahan = Kelurahan::select('id', 'name', 'code', 'pos_code')
                ->where('kecamatan_id', $kecamatanId)
                ->orderBy('name')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $kelurahan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching villages: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get complete address by kelurahan ID
     */
    public function getAlamatLengkap(Request $request)
    {
        try {
            $kelurahanId = $request->get('kelurahan_id');
            
            if (!$kelurahanId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Village ID is required'
                ], 400);
            }

            $kelurahan = Kelurahan::with(['kecamatan.kabupaten.provinsi'])
                ->find($kelurahanId);
            
            if (!$kelurahan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Village not found'
                ], 404);
            }

            $alamatLengkap = [
                'kelurahan' => $kelurahan->name,
                'kecamatan' => $kelurahan->kecamatan->name,
                'kabupaten' => $kelurahan->kecamatan->kabupaten->type . ' ' . $kelurahan->kecamatan->kabupaten->name,
                'provinsi' => $kelurahan->kecamatan->kabupaten->provinsi->name,
                'kode_pos' => $kelurahan->pos_code,
                'alamat_formatted' => $kelurahan->name . ', ' . 
                                   $kelurahan->kecamatan->name . ', ' . 
                                   $kelurahan->kecamatan->kabupaten->type . ' ' . $kelurahan->kecamatan->kabupaten->name . ', ' . 
                                   $kelurahan->kecamatan->kabupaten->provinsi->name . ' ' . 
                                   $kelurahan->pos_code
            ];
            
            return response()->json([
                'success' => true,
                'data' => $alamatLengkap
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching complete address: ' . $e->getMessage()
            ], 500);
        }
    }
}
