<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Http\Resources\JsonResponse;

class AlamatController extends Controller
{
    public function addAlamat(Request $request)
    {
        try {
            $prov = $this->provinsi($request->provinsi);
            $kab = $this->kabupaten($request->kabupaten);
            $kec = $this->kecamatan($request->kecamatan);
            $kel = $this->kelurahan($request->kelurahan);

            $data = Alamat::create([
                'detail_alamat' => $request->detail_alamat,
                'provinsi'      => $prov,
                'kabupaten'     => $kab,
                'kecamatan'     => $kec,
                'kelurahan'     => $kel,
            ]);

            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function updateAlamat(Request $request,$id)
    {
        try {
            $alamat = Alamat::where('id',$id)->first();
            $prov = $this->provinsi($request->provinsi);
            $kab = $this->kabupaten($request->kabupaten);
            $kec = $this->kecamatan($request->kecamatan);
            $kel = $this->kelurahan($request->kelurahan);

            $data = $alamat->update([
                'detail_alamat' => $request->detail_alamat,
                'provinsi'      => $prov,
                'kabupaten'     => $kab,
                'kecamatan'     => $kec,
                'kelurahan'     => $kel,
            ]);

            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function updateDetailAlamat(Request $request,$id)
    {
        try {
            $alamat = Alamat::where('id',$id)->first();
            $data = $alamat->update([
                'detail_alamat' => $request->detail_alamat,
            ]);

            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function deleteAlamat($id)
    {
        try {
            $data = Alamat::where('id',$id)->delete();
            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function provinsi($id)
    {
        $data = Provinsi::where('id',$id)->first();
        return $data->nama;
    }

    private function kabupaten($id)
    {
        $data = Kabupaten::where('id',$id)->first();
        return $data->nama;
    }

    private function kecamatan($id)
    {
        $data = Kecamatan::where('id',$id)->first();
        return $data->nama;
    }

    private function kelurahan($id)
    {
        $data = Kelurahan::where('id',$id)->first();
        return $data->nama;
    }

    // get alamat umum
    public function getKabupaten($id)
    {
        $data = Kabupaten::where('provinsi_id',$id)->get();
        if ($data == null) {
            return new JsonResponse(404,"Tidak ada data"); 
        }
        return new JsonResponse(200,"Data ditemukan",$data);
    }

    public function getKecamatan($id)
    {
        $data = Kecamatan::where('kabupaten_id',$id)->get();
        if ($data == null) {
            return new JsonResponse(404,"Tidak ada data"); 
        }
        return new JsonResponse(200,"Data ditemukan",$data);
    }

    public function getKelurahan($id)
    {
        $data = Kelurahan::where('kecamatan_id',$id)->get();
        if ($data == null) {
            return new JsonResponse(404,"Tidak ada data"); 
        }
        return new JsonResponse(200,"Data ditemukan",$data);
    }
}