<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Hewan;
use App\Models\Alamat;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Models\TransaksiProduk;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\PDFController;
use App\Models\Detail_Transaksi_Produk;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HewanController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AlamatController;

class KasirController extends Controller
{
    public function dashboard()
    {
        // laporan 11 bulan terakhir
        $year = self::penjualan12BulanAkhir();
        $jualBulan = $year[0];
        $titipBulan = $year[1];
        $bulan = $year[2];

        // laporan 1 minggu terakhir
        $mingguan = self::penjualanHarian();
        $jualHarian = $mingguan[0];
        $titipHarian = $mingguan[1];
        $hari = $mingguan[2];

        $jumlahAnjing = Produk::where('kode_produk', 'like', '%PA%')->count();
        $jumlahKucing = Produk::where('kode_produk', 'like', '%PK%')->count();
        $jumlahCustomer = User::where('role', '=', '0')->count();
        $totalPenjualan = (DB::table('transaksi_jasa')->sum('transaksi_jasa.total_harga_jasa')) + (DB::table('transaksi_produk')->sum('transaksi_produk.total_harga_produk'));
        
        $laris = self::produkLaris();

        $groom = self::getGroomingDashboard();
        $titip = self::getPenitipanDashboard();
        return view('user.dashboard', compact('groom','titip','jualHarian','titipHarian', 'hari','jualBulan','titipBulan','bulan', 'jumlahAnjing', 'jumlahKucing', 'jumlahCustomer', 'totalPenjualan','laris'));
    }

    private function getGroomingDashboard(){
        $data = DB::select('CALL getGroomingAll()');
        if(empty($data)){
            $data == null;
        }
        return $data;
    }

    private function getPenitipanDashboard(){
        $data = DB::select('CALL getPenitipanAll()');
        if(empty($data)){
            $data == null;
        }
        return $data;
    }

    private function penjualan12BulanAkhir(){
        $mulai = Carbon::now()->subMonths(11);
        $dapatJual = [];
        $dapatTitip = [];
        $bulan_tahun = [];
        for ($i = 1; $i <= 12; $i++) {
            $dat = DB::table('transaksi_produk')->whereMonth('tanggal_transaksi_produk',$mulai->month)->whereYear('tanggal_transaksi_produk',$mulai->year)->sum('jumlah_barang');
            $tip = DB::table('transaksi_jasa')->whereMonth('tanggal_transaksi_jasa',$mulai->month)->whereYear('tanggal_transaksi_jasa',$mulai->year)->sum('is_bayar');
            $bul = $mulai->isoFormat('MMMM Y');
            array_push($dapatJual, $dat);
            array_push($dapatTitip, $tip);
            array_push($bulan_tahun,$bul);
            $mulai = $mulai->addMonth();
        }
        $data = [
            $dapatJual,$dapatTitip, $bulan_tahun
        ];
        return $data;
    }

    private function produkLaris(){
        $cek = TransaksiProduk::get()->count();
        if ($cek > 0) {
            $data = DB::select('CALL ProdukTerlaris()');
        }else{
            $data = null;
        }
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $produk = Produk::where('id',$data[$key]->id)->first();
                $data[$key]->harga_produk = $produk->harga;
                $data[$key]->stok = $produk->stok;
                $data[$key]->bobot = $produk->bobot;
                if ($produk->gambar_produk != null) {
                    $data[$key]->gambar_produk = self::getFotoProduk($produk->gambar_produk);
                }else{
                    $data[$key]->gambar_produk = null;
                }
            }
        }
        return $data;
    }

    private function penjualanHarian()
    {
        $d = Carbon::now();
        $tgl_akhir = $d->day;
        $tgl_awal = $d->subDays(6)->day;
        $mulai = Carbon::now()->subDays(6);

        $dapatJual = [];
        $dapatTitip = [];
        $hari = [];
        try {

            $count = 0;
            for ($i = $tgl_awal; $i <= $tgl_akhir; $i++) {
                if ($count == 0) {
                    $temp = DB::table('transaksi_produk')->whereDate('tanggal_transaksi_produk', $mulai)->sum('jumlah_barang');
                    $temp1 = DB::table('transaksi_jasa')->whereDate('tanggal_transaksi_jasa', $mulai)->sum('is_bayar');
                    $temp2 = $mulai->isoFormat('dddd');
                } else {
                    $temp = DB::table('transaksi_produk')->whereDate('tanggal_transaksi_produk', $mulai)->sum('jumlah_barang');
                    $temp1 = DB::table('transaksi_jasa')->whereDate('tanggal_transaksi_jasa', $mulai)->sum('is_bayar');
                    $temp2 = $mulai->isoFormat('dddd');
                }
                $count++;
                array_push($dapatJual, $temp);
                array_push($dapatTitip, $temp1);
                array_push($hari, $temp2);
                $mulai = $mulai->addDay();
            }
            $data = [
                $dapatJual,$dapatTitip, $hari
            ];
            return $data;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function jualProduk()
    {
        $produk = Produk::all();
        $keranjang = Detail_Transaksi_Produk::all();
        $total_bayar = 0;
        $tanggal = Carbon::now()->isoFormat('D MMMM Y');
        $id_transaksi = rand(1000000000, 9999999999);
        foreach ($keranjang as $key => $value) {
            $keranjang[$key]->harga_total = $keranjang[$key]->harga * $keranjang[$key]->jumlah_barang;
            $total_bayar += $keranjang[$key]->harga_total;
        }
        return view('transaksi.transaksi_produk', compact('tanggal', 'produk', 'keranjang', 'total_bayar', 'id_transaksi'));
    }

    public function tambahKeranjang($id)
    {
        if (Auth::check() == true && auth()->user()->role == 1) {
            try {

                // get data produk
                $produk = Produk::where('kode_produk', $id)->first();

                // get data kasir
                $user = User::where('id', auth()->user()->id)->first();

                // cek stok produk
                if ($produk->stok <= 0) {
                    return new JsonResponse(404, "Stok Produk Ini Kosong");
                    // return redirect()->back()->withErrors('Stok Produk Ini Kosong');
                } else {
                    $cek = Detail_Transaksi_Produk::where('kode_produk', $produk->kode_produk)->first();
                    if ($cek == null) {
                        // klk data barang gk ada yang sama di keranjang
                        Detail_Transaksi_Produk::create([
                            'kode_produk'     => $produk->kode_produk,
                            'nama_barang'   => $produk->nama_produk,
                            'jumlah_barang' => 1,
                            'harga'         => $produk->harga,
                            'nama_kasir'    => $user->nama_lengkap,
                        ]);
                    } else {
                        // klk data barang ada yang sama di keranjang
                        $cek->update([
                            'jumlah_barang' => $cek->jumlah_barang + 1,
                        ]);
                    }

                    // itung pengurangan stok
                    $produk->update([
                        'stok'  => $produk->stok - 1,
                    ]);
                    return new JsonResponse(200, "Berhasil di tambahkan ke keranjang");
                    // return redirect()->back()->withSuccess('Berhasil di tambahkan ke keranjang');
                }
            } catch (\Throwable $th) {
                dd($th->getMessage());
                return redirect()->back()->withErrors($th->getMessage());
            }
        } else {
            return redirect()->route('user.logout')->withErrors('Salah Server Pak');
        }
    }

    public function transaksiProduk(Request $request)
    {
        // dd($request);
        try {
            if (Auth::check() == true && auth()->user()->role == 1) {
                $detail = Detail_Transaksi_Produk::all();
                $id_transaksi = $request->id_transaksi;
                $total_bayar = $request->total_bayar;
                $user_bayar = $request->user_membayar;
                $kembalian = $request->kembalian;

                $tanggal = Carbon::now();
                $d = date('Y-m-d H:i:s', strtotime($tanggal));
                foreach ($detail as $key => $value) {
                    $detail[$key]->harga_total = $detail[$key]->harga * $detail[$key]->jumlah_barang;
                    $da =  $this->inputTransaksi($detail[$key], $id_transaksi, $d);
                }
                $request->detail = $detail;
                $nota = new PDFController();
                return $nota->printNotaPembayaranProduk($request);
            } else {
                return redirect()->back()->withErrors('Salah Server Pak');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    private function inputTransaksi($data, $id_transaksi, $tanggal_sekarang)
    {
        // return $data;
        try {
            $produk = Produk::where('kode_produk', $data->kode_produk)->first();
            $trans = TransaksiProduk::create([
                'kode_transaksi'    => $id_transaksi,
                'user_id'           => auth()->user()->id,
                'produk_id'         => $produk->id,
                'jumlah_barang'     => $data->jumlah_barang,
                'tanggal_transaksi_produk'  => $tanggal_sekarang,
                'total_harga_produk' => $data->harga_total,
            ]);
            return $trans;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deleteKeranjang($id)
    {
        try {
            // get data di detail
            $detail = Detail_Transaksi_Produk::where('id', $id)->first();

            // get data produk
            $produk = Produk::where('kode_produk', $detail->kode_produk)->first();

            // update stok produk
            $stokBaru = $detail->jumlah_barang + $produk->stok;
            // dd($stokBaru);

            // update stok produk
            $produk->update([
                'stok'  => $stokBaru,
            ]);

            // detele data di detail
            $detail->delete();

            return redirect()->back()->withSuccess('Keranjang berhasil di update');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateKeranjang(Request $request, $kode_produk)
    {
        // dd($request);
        try {
            // get data di detail
            $detail = Detail_Transaksi_Produk::where('kode_produk', $kode_produk)->first();
            // dd($detail);

            // get data produk
            $produk = Produk::where('kode_produk', $kode_produk)->first();
            // dd($produk);

            $cekJumlah = $produk->stok - $request->jumlah_barang;
            // dd($cekJumlah);

            // cek jumlah barang
            if ($cekJumlah < 0) {
                return redirect()->back()->withErrors('Stok Produk Habis');
            } else {
                $produk->update([
                    'stok'  =>  $cekJumlah,
                ]);
                $detail->update([
                    'jumlah_barang' => $detail->jumlah_barang + $request->jumlah_barang,
                ]);
                return redirect()->back()->withSuccess('Keranjang berhasil di update');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateKeranjangJSTambah($kode_produk)
    {
        // dd($request);
        try {
            // get data di detail
            $detail = Detail_Transaksi_Produk::where('kode_produk', $kode_produk)->first();
            // dd($detail);

            // get data produk
            $produk = Produk::where('kode_produk', $kode_produk)->first();
            // dd($produk);

            $cekJumlah = $produk->stok - 1;
            // dd($cekJumlah);

            // cek jumlah barang
            if ($cekJumlah < 0) {
                return redirect()->back()->withErrors('Stok Produk Habis');
            } else {
                $produk->update([
                    'stok'  =>  $cekJumlah,
                ]);
                $detail->update([
                    'jumlah_barang' => $detail->jumlah_barang + 1,
                ]);
                return new JsonResponse(200, 'Keranjang berhasil di update');
                // return redirect()->back()->withSuccess('Keranjang berhasil di update');
            }
        } catch (\Throwable $th) {
            return new JsonResponse(500, $th->getMessage());
            // dd($th->getMessage());
            // return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateKeranjangJSKurang($kode_produk)
    {
        // dd($request);
        try {
            // get data di detail
            $detail = Detail_Transaksi_Produk::where('kode_produk', $kode_produk)->first();
            // return $detail;

            // get data produk
            $produk = Produk::where('kode_produk', $kode_produk)->first();
            // dd($produk);
            // return $produk;

            $cekJumlah = $produk->stok + 1;
            // dd($cekJumlah);
            // return $cekJumlah;

            // cek jumlah barang
            $produk->update([
                'stok'  =>  $cekJumlah,
            ]);

            if ($detail->jumlah_barang == 1) {
                $detail->delete();
            } else {
                $detail->update([
                    'jumlah_barang' => $detail->jumlah_barang - 1,
                ]);
            }

            return new JsonResponse(200, 'Keranjang berhasil di update');
        } catch (\Throwable $th) {
            return new JsonResponse(500, $th->getMessage());
            // dd($th->getMessage());
            // return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function resetKeranjang()
    {
        $data = Detail_Transaksi_Produk::all();
        if ($data != null) {
            foreach ($data as $val) {
                $produk = Produk::where('kode_produk', $val->kode_produk)->first();
                $produk->update([
                    'stok'  => $val->jumlah_barang + $produk->stok,
                ]);
            }
            DB::select('CALL resetKeranjang()');
        }
        return redirect()->back()->withSuccess('Keranjang Kosong');
    }

    public function getProduk($id)
    {
        $data = Produk::where('kode_produk', $id)->first();
        if ($data != null) {
            return new JsonResponse(true, "Data Ditemukan", $data);
        } else {
            return new JsonResponse(false, "Tidak ada data");
        }
    }

    private function getFotoHewan($file)
    {
        try {
            $img = Image::make(storage_path('app/public/hewan/' . $file))->encode('data-url');
            if (isset($img)) {
                return $img->encoded;
            }
            return null;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function customer()
    {
        $data = Provinsi::where('id', 34)->first();
        $customer = DB::select('CALL getCustomer()');
        $kabupaten = Kabupaten::where('provinsi_id', 34)->get();
        $user = User::where('role', 0)->get();
        foreach ($customer as $key => $value) {
            if ($customer[$key]->gambar_hewan != null) {
                $customer[$key]->gambar_hewan = $this->getFotoHewan($customer[$key]->gambar_hewan);
            }
        }
        return view('kasir.customer', compact('data', 'user', 'customer', 'kabupaten'));
    }

    public function saveImageHewan(Request $request)
    {
        try {
            $folderPath = storage_path('app/public/hewan/');
            if (!file_exists($folderPath)) {
                Storage::disk('local')->makeDirectory('public/hewan/');
            }
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $file = $folderPath . $fileName;

            file_put_contents($file, $image_base64);
            return new JsonResponse(200, "Berhasil", $fileName);
        } catch (\Throwable $th) {
            return new JsonResponse(500, $th->getMessage());
        }
    }

    public function create_customer(Request $request)
    {
        // dd($request);
        try {
            $rules = [
                'nama_lengkap'   => 'required',
                'gender'         => 'required',
                'email'          => 'required',
                'no_telepon'      => 'required',
                'detail_alamat'  => 'required',
                'provinsi'       => 'required',
                'kabupaten'      => 'required',
                'kecamatan'      => 'required',
                'kelurahan'      => 'required',
            ];
            $message = [
                'nama_lengkap.required'   => 'Nama lengkap harus diisi',
                'gender.required'         => 'Gender harus diisi',
                'email.required'          => 'Email harus diisi',
                'no_telepon.required'      => 'Nomor Telepon Harus Diisi',
                'detail_alamat.required'  => 'Detail Alamat Harus Disi',
                'provinsi.required'       => 'Provinsi harus diisi',
                'kabupaten.required'      => 'Kabupaten harus diisi',
                'kecamatan.required'      => 'Kecamatan harus diisi',
                'kelurahan.required'      => 'Kelurahan harus diisi',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            // add new Alamat
            $alamat = new AlamatController;
            $alamat = $alamat->addAlamat($request);
            // dd($alamat);
            // add new user 
            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->no_telepon), //default dari no telpon
                'gender' => $request->gender,
                'no_telepon' => $request->no_telepon,
                'role' => 0,
                'id_alamat' => $alamat->id,
            ]);
            return redirect()->back()->withSuccess('Data Pemilik Berhasil Di Tambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function update_customer(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();
            // dd($user);
            $data = [];
            if ($request->nama_lengkap != null) {
                $data['nama_lengkap'] = $request->nama_lengkap;
            }
            if ($request->email != null) {
                $data['email'] = $request->email;
            }
            if ($request->gender != null) {
                $data['gender'] = $request->gender;
            }
            if ($request->no_telpon != null) {
                $data['no_telpon']  = $request->no_telpon;
            }

            // add new Alamat
            if ($request->kabupaten != null && $request->kecamatan != null && $request->kelurahan != null) {
                $alamat = new AlamatController;
                $alamat->updateAlamat($request, $user->id_alamat);
            }

            // add new user 
            // dd($request);
            $user->update($data);
            // dd($user);
            return redirect()->back()->withSuccess('Data Customer Berhasil Di Ubah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deleteCustomer($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $alamat = Alamat::where('id', $user->id_alamat)->first();
            $hewan = Hewan::where('id_user', $id)->delete();
            $user->delete();
            $alamat->delete();
            return redirect()->back()->withSuccess('Data Customer Berhasil Di Hapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
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

    public function settingProfile()
    {
        if (Auth::check() == true && auth()->user()->role == 1) {
            $user = DB::select('CALL getProfile(?)', array(auth()->user()->id));
            $data = (object) $user[0];
            $prov = Provinsi::where('id', 34)->first();
            return view('user.profile', compact('data', 'prov'));
        } else {
            return redirect()->route('login')->withErrors('Salah Server Pak');
        }
    }

    public function uploadFotoProfile(Request $request)
    {
        try {
            $user = User::where('id', auth()->user()->id)->first();
            if ($user->foto_profile != null) {
                $path = public_path('profile/');
                if (!file_exists($path)) {
                    File::makeDirectory($path);
                }
                $pathFile = $path = public_path($path . $user->foto_profile);
                if (File::exists($pathFile)) {
                    File::delete($pathFile);
                }
            }
            $path = public_path('profile/');

            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $file = $path . $fileName;

            file_put_contents($file, $image_base64);

            $user->update([
                'foto_profile' => $fileName,
            ]);
            return new JsonResponse(200, "Foto Profile Berhasil Di Ubah");
        } catch (\Throwable $th) {
            return new JsonResponse(500, $th->getMessage());
        }
    }

    public function updateProfile(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();
            if ($user != null) {
                $data = [];
                if ($request->nama_lengkap != null) {
                    $data['nama_lengkap'] = $request->nama_lengkap;
                }
                if ($request->email != null) {
                    $data['email'] = $request->email;
                }
                if ($request->gender != null) {
                    $data['gender'] = $request->gender;
                }
                if ($request->no_telepon != null) {
                    $data['no_telepon'] = $request->no_telepon;
                }
                if ($request->provinsi != null && $request->kabupaten != null && $request->kecamatan != null && $request->kelurahan && $request->detail_alamat != null) {
                    $alamat = new AlamatController;
                    $alamat = $alamat->updateAlamat($request, $user->id_alamat);
                }
                if ($request->detail_alamat != null) {
                    $alamat = new AlamatController;
                    $alamat = $alamat->updateDetailAlamat($request, $user->id_alamat);
                }
                $user->update($data);
                return redirect()->back()->withSuccess('Informasi Akun Sudah Di Ubah');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            // validasi
            $rules = [
                'password'       => 'required|confirmed',
            ];
            $message = [
                'password.required'     => 'Password harus diisi',
                'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            // cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            $user = User::where('id', $id)->first();
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            return redirect()->back()->withSuccess('Password berhasil di ubah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }


    public function getKabupaten($id)
    {
        $data = Kabupaten::where('provinsi_id', $id)->get();
        if ($data == null) {
            return new JsonResponse(404, "Tidak ada data");
        }
        return new JsonResponse(200, "Data ditemukan", $data);
    }

    public function getKecamatan($id)
    {
        $data = Kecamatan::where('kabupaten_id', $id)->get();
        if ($data == null) {
            return new JsonResponse(404, "Tidak ada data");
        }
        return new JsonResponse(200, "Data ditemukan", $data);
    }

    public function getKelurahan($id)
    {
        $data = Kelurahan::where('kecamatan_id', $id)->get();
        if ($data == null) {
            return new JsonResponse(404, "Tidak ada data");
        }
        return new JsonResponse(200, "Data ditemukan", $data);
    }
}
