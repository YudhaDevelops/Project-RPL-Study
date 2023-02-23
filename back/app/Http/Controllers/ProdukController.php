<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    private function getFoto($file)
    {
        try {
            $img = Image::make(public_path('/produk/' . $file))->encode('data-url');
            if (isset($img)) {
                return $img->encoded;
            }
            return null;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function produkAnjing()
    {
        $data = Produk::where('kode_produk', 'like', '%PA%')->get();
        foreach ($data as $key => $value) {
            if ($data[$key]->gambar_produk != null) {
                $data[$key]->gambar_produk = $this->getFoto($data[$key]->gambar_produk);
            }
        }
        $idGenerate = "PA" . rand(1000000, 9999999);
        return view('kasir.produk_anjing', compact('data', 'idGenerate'));
    }

    public function simpanProdukAnjing(Request $request)
    {
        // dd($request);
        try {
            $rules = [
                'nama_produk'   => 'required|min:3|max:200',
                'bobot'         => 'required|numeric',
                'harga'         => 'required|numeric',
                'stok'          => 'required|numeric',
            ];
            $message = [
                'nama_produk.required'  => 'Nama produk harus diisi',
                'nama_produk.min'       => 'Nama produk minimal 3 karakter',
                'nama_produk.max'       => 'Nama produk maksimal 200 karakter',
                'bobot.required'        => 'Bobot produk harus diisi',
                'bobot.numeric'         => 'Bobot prduk harus berupa angka',
                'harga.required'        => 'Harga beli produk harus diisi',
                'harga.numeric'         => 'Harga beli produk harus berupa angka',
                'stok.required'         => 'Stok produk harus diisi',
                'stok.numeric'          => 'Stok produk harus berupa angka',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            if ($request->hasFile('gambar_produk')) {
                $destinationPath = public_path('/produk');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory('produk');
                }
                $image = $request->file('gambar_produk');
                $fileName = time() . '.' . $request->file('gambar_produk')->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);

                $imgFile = Image::make($destinationPath . '/' . $fileName);
                $imgFile->fit(800, 800, function ($constraint) {
                    $constraint->upsize();
                })->save($destinationPath . '/' . $fileName);
            } else {
                $fileName = null;
            }

            // dd($request);
            $data = Produk::create([
                'kode_produk'     => $request->kode_produk,
                'nama_produk'   => $request->nama_produk,
                'bobot'         => $request->bobot,
                'harga'         => $request->harga,
                'stok'          => $request->stok,
                'gambar_produk' => $fileName,
            ]);
            return redirect()->back()->withSuccess('Data Produk Makanan Anjing Berhasil Di Tambahkan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateProdukAnjing(Request $request, $id)
    {
        // dd($request,$id);
        try {
            $rules = [
                'nama_produk'   => 'required|min:3|max:200',
                'bobot'         => 'required|numeric',
                'harga'         => 'required|numeric',
                'stok'          => 'required|numeric',
            ];
            $message = [
                'nama_produk.required'  => 'Nama produk harus diisi',
                'nama_produk.min'       => 'Nama produk minimal 3 karakter',
                'nama_produk.max'       => 'Nama produk maksimal 200 karakter',
                'bobot.required'        => 'Bobot produk harus diisi',
                'bobot.numeric'         => 'Bobot prduk harus berupa angka',
                'harga.required'        => 'Harga beli produk harus diisi',
                'harga.numeric'         => 'Harga beli produk harus berupa angka',
                'stok.required'         => 'Stok produk harus diisi',
                'stok.numeric'          => 'Stok produk harus berupa angka',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            // cek data by id
            $produk = Produk::where('id', $id)->first();
            // dd($produk);
            // dd($request);

            // olah gambar baru
            if ($request->file('gambar_produk_update') != null) {
                $destinationPath = public_path('/produk');
                // dd($produk);
                if (File::exists($destinationPath . '/' . $produk->gambar_produk)) {
                    File::delete($destinationPath . '/' . $produk->gambar_produk);
                }
                if (!File::exists($destinationPath)) {
                    File::makeDirectory('produk');
                }
                $image = $request->file('gambar_produk_update');
                $fileName = time() . '.' . $request->file('gambar_produk_update')->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);

                $imgFile = Image::make($destinationPath . '/' . $fileName);
                $imgFile->fit(800, 800, function ($constraint) {
                    $constraint->upsize();
                })->save($destinationPath . '/' . $fileName);
            } else {
                $fileName = $produk->gambar_produk;
            }


            $data = $produk->update([
                'nama_produk'   => $request->nama_produk,
                'bobot'         => $request->bobot,
                'harga'         => $request->harga,
                'stok'          => $request->stok,
                'gambar_produk' => $fileName,
            ]);
            return redirect()->back()->withSuccess('Data Produk Makanan Anjing Berhasil Di Update');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deleteProdukAnjing($id)
    {
        try {
            $data = Produk::where('id', $id)->first();
            $destinationPath = public_path('/produk');
            if (File::exists($destinationPath . '/' . $data->gambar_produk)) {
                File::delete($destinationPath . '/' . $data->gambar_produk);
            }
            if ($data == null) {
                return redirect()->back()->withErrors('Data Tidak Ditemukan');
            } else {
                $data->delete();
                return redirect()->back()->withSuccess('Data Produk Berhasil Dihapus');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    // bagian kucing
    public function produkKucing()
    {
        try {
            $data = Produk::where('kode_produk', 'like', '%PK%')->get();
            foreach ($data as $key => $value) {
                if ($data[$key]->gambar_produk != null) {
                    $data[$key]->gambar_produk = $this->getFoto($data[$key]->gambar_produk);
                }
            }
            $idGenerate = "PK" . rand(1000000, 9999999);
            return view('kasir.produk_kucing', compact('data', 'idGenerate'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function simpanProdukKucing(Request $request)
    {
        // dd($request);
        try {
            $rules = [
                'nama_produk'   => 'required|min:3|max:200',
                'bobot'         => 'required|numeric',
                'harga'         => 'required|numeric',
                'stok'          => 'required|numeric',
            ];
            $message = [
                'nama_produk.required'  => 'Nama produk harus diisi',
                'nama_produk.min'       => 'Nama produk minimal 3 karakter',
                'nama_produk.max'       => 'Nama produk maksimal 200 karakter',
                'bobot.required'        => 'Bobot produk harus diisi',
                'bobot.numeric'         => 'Bobot prduk harus berupa angka',
                'harga.required'        => 'Harga beli produk harus diisi',
                'harga.numeric'         => 'Harga beli produk harus berupa angka',
                'stok.required'         => 'Stok produk harus diisi',
                'stok.numeric'          => 'Stok produk harus berupa angka',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            if ($request->hasFile('gambar_produk')) {
                $destinationPath = public_path('/produk');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory('produk');
                }
                $image = $request->file('gambar_produk');
                $fileName = time() . '.' . $request->file('gambar_produk')->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);

                $imgFile = Image::make($destinationPath . '/' . $fileName);
                $imgFile->fit(800, 800, function ($constraint) {
                    $constraint->upsize();
                })->save($destinationPath . '/' . $fileName);
            } else {
                $fileName = null;
            }

            // dd($request);
            $data = Produk::create([
                'kode_produk'     => $request->kode_produk,
                'nama_produk'   => $request->nama_produk,
                'bobot'         => $request->bobot,
                'harga'         => $request->harga,
                'stok'          => $request->stok,
                'gambar_produk' => $fileName,
            ]);
            return redirect()->back()->withSuccess('Data Produk Makanan Kucing Sudah Di Tambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateProdukKucing(Request $request, $id)
    {
        // dd($request,$id);
        try {
            $rules = [
                'nama_produk'   => 'required|min:3|max:200',
                'bobot'         => 'required|numeric',
                'harga'         => 'required|numeric',
                'stok'          => 'required|numeric',
            ];
            $message = [
                'nama_produk.required'  => 'Nama produk harus diisi',
                'nama_produk.min'       => 'Nama produk minimal 3 karakter',
                'nama_produk.max'       => 'Nama produk maksimal 200 karakter',
                'bobot.required'        => 'Bobot produk harus diisi',
                'bobot.numeric'         => 'Bobot prduk harus berupa angka',
                'harga.required'        => 'Harga beli produk harus diisi',
                'harga.numeric'         => 'Harga beli produk harus berupa angka',
                'stok.required'         => 'Stok produk harus diisi',
                'stok.numeric'          => 'Stok produk harus berupa angka',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            // cek data by id
            $produk = Produk::where('id', $id)->first();
            // dd($produk);
            // dd();

            // olah gambar baru
            if ($request->file('gambar_produk_update') != null) {
                $destinationPath = public_path('/produk');
                // dd($produk);
                if (File::exists($destinationPath . '/' . $produk->gambar_produk)) {
                    File::delete($destinationPath . '/' . $produk->gambar_produk);
                }
                if (!File::exists($destinationPath)) {
                    File::makeDirectory('produk');
                }
                $image = $request->file('gambar_produk_update');
                $fileName = time() . '.' . $request->file('gambar_produk_update')->getClientOriginalExtension();
                $image->move($destinationPath, $fileName);

                $imgFile = Image::make($destinationPath . '/' . $fileName);
                $imgFile->fit(800, 800, function ($constraint) {
                    $constraint->upsize();
                })->save($destinationPath . '/' . $fileName);
            } else {
                $fileName = $produk->gambar_produk;
            }
            // dd($fileName);

            $data = $produk->update([
                'nama_produk'   => $request->nama_produk,
                'bobot'         => $request->bobot,
                'harga'         => $request->harga,
                'stok'          => $request->stok,
                'gambar_produk' => $fileName,
            ]);
            return redirect()->back()->withSuccess('Data Produk Makanan Kucing Sudah Di Ubah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deleteProdukKucing($id)
    {
        try {
            $data = Produk::where('id', $id)->first();
            $destinationPath = public_path('/produk');
            if (File::exists($destinationPath . '/' . $data->gambar_produk)) {
                File::delete($destinationPath . '/' . $data->gambar_produk);
            }
            if ($data == null) {
                return redirect()->back()->withErrors('Data Tidak Ditemukan');
            } else {
                $data->delete();
                return redirect()->back()->withSuccess('Data Produk Berhasil Dihapus');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
