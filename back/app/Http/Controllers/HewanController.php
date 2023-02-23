<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HewanController extends Controller
{
    public function addHewan(Request $request)
    {
        try {
            // dd($request);
            $rules = [
                'nama_hewan'     => 'required',
                'jenis_hewan'    => 'required',
                'umur_hewan'     => 'required',
                'nama_pemilik'   => 'required',
                'gambar_hewan'   => 'required',
            ];
            $message = [
                'nama_hewan.required'     => 'Nama hewan harus diisi',
                'jenis_hewan.required'    => 'Jenis hewan harus diisi',
                'umur_hewan.required'     => 'Umur hewan harus diisi',
                'nama_pemilik.required'   => 'Pemilik belum di pilih',
                'gambar_hewan.required'   => 'Gambar Image Tidak Masuk',
            ];
            $validator = Validator::make($request->all(), $rules, $message);
 
            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            if ($request->jenis_hewan == "Anjing") {
                $idGenerate = "HA".rand(1000000,9999999);
            }else{
                $idGenerate = "HK".rand(1000000,9999999);
            }
            $data = Hewan::create([
                'id_hewan'   => $idGenerate,
                'id_user'    => $request->nama_pemilik,
                'nama_hewan' => $request->nama_hewan,
                'tipe_hewan' => $request->jenis_hewan,
                'umur_hewan' => $request->umur_hewan,
                'gambar_hewan' => $request->gambar_hewan,
            ]);
            return redirect()->back()->withSuccess('Data Hewan Berhasil Di Simpan');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function updateHewan(Request $request,$id)
    {
        try {
            // dd($id);
            $rules = [
                'nama_hewan'     => 'required',
                'jenis_hewan'    => 'required',
                'umur_hewan'     => 'required',
            ];
            $message = [
                'nama_hewan.required'     => 'Nama hewan harus diisi',
                'jenis_hewan.required'    => 'Jenis hewan harus diisi',
                'umur_hewan.required'     => 'Umur hewan harus diisi',
            ];
            $validator = Validator::make($request->all(), $rules, $message);
 
            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            $hewan = Hewan::where('id_hewan',$id)->first();
            $simpan = [];

            // olah gambar baru
            if ($request->hasFile('gambar_hewan')) {
                $destinationPath = storage_path('app/public/hewan');
                if (!file_exists($destinationPath)) {
                    Storage::disk('local')->makeDirectory('public/hewan/');
                }
                if (Storage::disk('local')->exists('public/hewan/' . $hewan->gambar_hewan)) {
                    Storage::delete('public/hewan/' . $hewan->gambar_hewan);
                }
                $image = $request->file('gambar_hewan');
                $fileName = time() . '.' . $request->file('gambar_hewan')->extension();
                $imgFile = Image::make($image->getRealPath());
                $imgFile->fit(800, 800, function ($constraint) {
                    $constraint->upsize();
                })->save($destinationPath . '/' . $fileName);

                $simpan['gambar_hewan'] = $fileName;
            } else {
                $fileName = $hewan->gambar_hewan;
                $simpan['gambar_hewan'] = $fileName;
            }

            if ($request->id_user != null) {
                $simpan['id_user'] = $request->id_user;
            }
            if ($request->nama_hewan != null) {
                $simpan['nama_hewan'] = $request->nama_hewan;
            }
            if ($request->jenis_hewan != null) {
                $simpan['tipe_hewan'] = $request->jenis_hewan;
            }
            if ($request->umur_hewan != null) {
                $simpan['umur_hewan'] = $request->umur_hewan;
            }
            Hewan::where('id_hewan',$id)->update($simpan);
            return redirect()->back()->withSuccess('Data Hewan Berhasil Diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function deleteHewan($id)
    {
        Hewan::where('id_hewan',$id)->delete();
        return redirect()->back()->withSuccess('Data Hewan Berhasil Dihapus');
    }
}
