<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jasa;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\TransaksiProduk;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class WebController extends Controller
{
    public function landing()
    {
        $larisAnjing = self::produkLarisAnjing();
        $larisKucing = self::produkLarisKucing();
        $harga_penitipan = Jasa::where('id', 1)->first();
        $harga_gromStan = Jasa::where('id', 2)->first();
        $harga_gromSpes = Jasa::where('id', 3)->first();
        return view('landing.landing', compact('larisAnjing', 'larisKucing', 'harga_penitipan', 'harga_gromStan', 'harga_gromSpes'));
    }

    private function produkLarisAnjing()
    {
        $cek = TransaksiProduk::get()->count();
        if ($cek >= 1) {
            $data = DB::select('CALL LarisAnjing()');
        } else {
            $data = null;
        }
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $produk = Produk::where('id', $data[$key]->id_produk)->first();
                $data[$key]->harga_produk = $produk->harga;
                $data[$key]->stok = $produk->stok;
                $data[$key]->bobot = $produk->bobot;
                if ($produk->gambar_produk != null) {
                    $data[$key]->gambar_produk = self::getFotoProduk($produk->gambar_produk);
                } else {
                    $data[$key]->gambar_produk = null;
                }
            }
        }
        return $data;
    }

    private function produkLarisKucing()
    {
        $cek = TransaksiProduk::get()->count();
        if ($cek > 0) {
            $data = DB::select('CALL LarisKucing()');
        } else {
            $data = null;
        }
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $produk = Produk::where('id', $data[$key]->id_produk)->first();
                $data[$key]->harga_produk = $produk->harga;
                $data[$key]->stok = $produk->stok;
                $data[$key]->bobot = $produk->bobot;
                if ($produk->gambar_produk != null) {
                    $data[$key]->gambar_produk = self::getFotoProduk($produk->gambar_produk);
                } else {
                    $data[$key]->gambar_produk = null;
                }
            }
        }
        return $data;
    }

    private function getFotoProduk($file)
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

    public function getProduk(Request $request)
    {
        // dd($request);
        $data = Produk::paginate(24);
        $produk = [];

        if ($request->key != null) {
            if ($request->filter != null) {
                if ($request->filter == "terbaru") {
                    $data = Produk::where('nama_produk', 'LIKE', '%' . $request->key . '%')
                        ->orderBy('created_at', 'desc')->paginate(24);
                } else if ($request->filter == "terlaris") {
                    $cek = TransaksiProduk::get()->count();
                    if ($cek >= 1) {
                        $data = self::produkLarisWithKey($request->key);
                    }
                } else if ($request->filter == "rendah_tinggi") {
                    $data = Produk::where('nama_produk', 'LIKE', '%' . $request->key . '%')
                        ->orderBy('harga', 'asc')->paginate(24);
                } else if ($request->filter == "tinggi_rendah") {
                    $data = Produk::where('nama_produk', 'LIKE', '%' . $request->key . '%')
                        ->orderBy('harga', 'desc')->paginate(24);
                } else if ($request->filter == "asc_name") {
                    $data = Produk::where('nama_produk', 'LIKE', '%' . $request->key . '%')
                        ->orderBy('nama_produk', 'asc')->paginate(24);
                } else if ($request->filter == "desc_name") {
                    $data = Produk::where('nama_produk', 'LIKE', '%' . $request->key . '%')
                        ->orderBy('nama_produk', 'desc')->paginate(24);
                }
            } else {
                $data = Produk::where('nama_produk', 'LIKE', '%' . $request->key . '%')->paginate(24);
            }
            $data = null;
        }
        
        if ($request->filter != null && $request->key == null) {
            if ($request->filter == "terbaru") {
                $data = Produk::orderBy('created_at', 'desc')->paginate(24);
            } else if ($request->filter == "terlaris") {
                $cek = TransaksiProduk::get()->count();
                if ($cek >= 1) {
                    $data = self::produkLarisNoKey();
                }
            } else if ($request->filter == "rendah_tinggi") {
                $data = Produk::orderBy('harga', 'asc')->paginate(24);
            } else if ($request->filter == "tinggi_rendah") {
                $data = Produk::orderBy('harga', 'desc')->paginate(24);
            } else if ($request->filter == "asc_name") {
                $data = Produk::orderBy('nama_produk', 'asc')->paginate(24);
            } else if ($request->filter == "desc_name") {
                $data = Produk::orderBy('nama_produk', 'desc')->paginate(24);
            }
        }

        $produk = $data;
        
        if($data != null){
            foreach ($produk as $key => $value) {
                if ($produk[$key]->gambar_produk != null) {
                    $produk[$key]->gambar_produk = $this->getFoto($produk[$key]->gambar_produk);
                }
            }    
        }
        
        // dd($produk);
        return view('landing.produk', ['produk' => $produk]);
    }
    
    private function produkLarisNoKey(){
        $cek = TransaksiProduk::get()->count();
        if ($cek > 0) {
            $data = DB::select('CALL LarisNoKey()');
        }else{
            $data = null;
        }
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $produk = Produk::where('id',$data[$key]->id_produk)->first();
                $data[$key]->harga = $produk->harga;
                $data[$key]->stok = $produk->stok;
                $data[$key]->bobot = $produk->bobot;
                if ($produk->gambar_produk != null) {
                    $data[$key]->gambar_produk = $produk->gambar_produk;
                }else{
                    $data[$key]->gambar_produk = null;
                }
            }
        }
        return $data;
    }
    
    private function produkLarisWithKey($nama_produk){
        $cek = TransaksiProduk::get()->count();
        if ($cek > 0) {
            $data = DB::select('CALL LarisWithKey(?)', array($nama_produk));
        }else{
            $data = null;
        }
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $produk = Produk::where('id',$data[$key]->id_produk)->first();
                $data[$key]->harga = $produk->harga;
                $data[$key]->stok = $produk->stok;
                $data[$key]->bobot = $produk->bobot;
                if ($produk->gambar_produk != null) {
                    $data[$key]->gambar_produk = $produk->gambar_produk;
                }else{
                    $data[$key]->gambar_produk = null;
                }
            }
        }
        return $data;
    }

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

    public function chartMingguan()
    {
        $d = Carbon::now();
        $tgl_akhir = $d->day;
        $tgl_awal = $d->subDays(6)->day;
        $mulai = Carbon::now()->subDays(6);

        $dapat = [];
        try {
            // echo $i . ',';
            $count = 0;
            for ($i = $tgl_awal; $i <= $tgl_akhir; $i++) {
                if ($count == 0) {
                    $temp = self::getDataBerdasarTanggal($mulai);
                } else {
                    $temp = self::getDataBerdasarTanggal($mulai);
                }
                $count++;
                array_push($dapat, $temp);
                $mulai = $mulai->addDay();
            }
            return new JsonResponse(200, 'Berhasil', $dapat);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function getHariChartMingguan()
    {
        $d = Carbon::now();
        $tgl_akhir = $d->day;
        $tgl_awal = $d->subDays(6)->day;
        $mulai = Carbon::now()->subDays(6);

        $dapat = [];
        try {
            $count = 0;
            for ($i = $tgl_awal; $i <= $tgl_akhir; $i++) {
                if ($count == 0) {
                    $temp = $mulai->isoFormat('dddd');
                } else {
                    $temp = $mulai->isoFormat('dddd');
                }
                $count++;
                array_push($dapat, $temp);
                $mulai = $mulai->addDay();
            }
            return new JsonResponse(200, 'Berhasil', $dapat);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    private function getDataBerdasarTanggal($tanggal)
    {
        $dat = DB::table('transaksi_produk')->whereDate('tanggal_transaksi_produk', $tanggal)->sum('jumlah_barang');
        return $dat;
    }
}
