<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Jasa;
use App\Models\User;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use App\Models\TransaksiJasa;
use App\Models\TransaksiProduk;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AlamatController;

class OwnerController extends Controller
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

        $jumlahAnjing = Produk::where('kode_produk', 'like' , '%PA%')->count();
        $jumlahKucing = Produk::where('kode_produk', 'like' , '%PK%')->count();
        $jumlahCustomer = User::where('role', '=', '0')->count();
        $totalPenjualan = (DB::table('transaksi_jasa')->sum('transaksi_jasa.total_harga_jasa')) + (DB::table('transaksi_produk')->sum('transaksi_produk.total_harga_produk'));
        
        $groom = self::getGroomingDashboard();
        $titip = self::getPenitipanDashboard();

        return view('user.dashboard', compact('titip','groom','hari','bulan','jualHarian','titipHarian','jualBulan','titipBulan','laris','jumlahAnjing', 'jumlahKucing', 'jumlahCustomer', 'totalPenjualan'));
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


    public function accountKasir()
    {
        $prov = Provinsi::where('id',34)->first();
        $kasir = DB::select('CALL getKasir()');
        $kabupaten = Kabupaten::where('provinsi_id',34)->get();

        return view('owner.dataKasir',compact('kasir','prov','kabupaten'));
    }

    public function addAccountKasir(Request $request)
    {
        // dd($request);
        try {
            $rules = [
                'nama_lengkap'   => 'required',
                'email'          => 'required',
                'gender'         => 'required',
                'no_telepon'      => 'required',
                'detail_alamat'  => 'required',
                'provinsi'       => 'required',
                'kabupaten'      => 'required',
                'kecamatan'      => 'required',
                'kelurahan'      => 'required',
                'password'       => 'required|confirmed',
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
                'password.required'     => 'Password harus diisi',
                'password.confirmed'    => 'Password tidak sama dengan konfirmasi password',
            ];
            $validator = Validator::make($request->all(), $rules, $message);
 
            // cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
            
            // add new Alamat
            $alamat = new AlamatController;
            $alamat = $alamat->addAlamat($request);
            
            // add new user 
            $user = User::create([
                'nama_lengkap'=>$request->nama_lengkap,
                'email'=>$request->email,
                'password'=>Hash::make($request->password), 
                'gender' => $request->gender,
                'no_telepon' => $request->no_telepon,
                'role' => 1,
                'id_alamat' => $alamat->id,
            ]);
            // dd($user);
            return redirect()->back()->withSuccess('Data Kasir Berhasil Di Tambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateAccountKasir(Request $request,$id)
    {
        // dd($request,$id);
        try {
            $user = User::where('id',$id)->first();
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
                }if ($request->provinsi != null && $request->kabupaten != null && $request->kecamatan != null && $request->kelurahan && $request->detail_alamat != null) {
                    $alamat = new AlamatController;
                    $alamat = $alamat->updateAlamat($request,$user->id_alamat);
                }
                if ($request->detail_alamat != null) {
                    $alamat = new AlamatController;
                    $alamat = $alamat->updateDetailAlamat($request,$user->id_alamat);
                }
                //  update Alamat
                $alamat = new AlamatController;
                $alamat = $alamat->updateAlamat($request,$user->id_alamat);

                // update user
                $user->update($data);
                return redirect()->back()->withSuccess('Data Kasir Berhasil Di Ubah');
            }
            
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deleteAccountKasir($id)
    {
        try {
            $user = User::where('id',$id)->first();
            $alamat_id = $user->id_alamat;
            $user->delete();
            $alamat = new AlamatController;
            $alamat = $alamat->deleteAlamat($alamat_id);
            return redirect()->back()->withSuccess('Data Kasir Berhasil Di Hapus');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function settingJasa()
    {
        try {
            $data = Jasa::all();
            foreach ($data as $key => $value) {
                if ($data[$key]->gambar_jasa != null) {
                    $data[$key]->gambar_jasa = $this->getFoto($data[$key]->gambar_jasa);
                }
            }
            // dd($data);
            return view('owner.settingJasa',compact('data'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

    }

    private function getFoto($file){
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

    public function laporanPenjualan(Request $request)
    { 
        $data = TransaksiProduk::with('user')->get();
        $laporan = [];
        $key_bulan = null;
        $key_range1 = null;
        $key_range2 = null;
        
        if ($request->select_bulan != null) {
            $key_bulan = $request->select_bulan;
            $b = date('m', strtotime($request->select_bulan));
            $t = date('Y', strtotime($request->select_bulan));
            $data = TransaksiProduk::with('user')->whereMonth('tanggal_transaksi_produk',$b)->whereYear('tanggal_transaksi_produk',$t)->get();    
            // dd($data);
        }

        if ($request->range_tanggal_start != null && $request->range_tanggal_end != null) {
            $key_range1 = $request->range_tanggal_start;
            $key_range2 = $request->range_tanggal_end;
            $m = date('Y-m-d', strtotime($request->range_tanggal_start));
            $s = date('Y-m-d', strtotime($request->range_tanggal_end));
            $data = TransaksiProduk::with('user')->whereBetween('tanggal_transaksi_produk',[$m, $s])->get();    
        }

        $laporan = $data;

        return view('owner.laporan_penjualan',compact('laporan','key_bulan','key_range1','key_range2'));
    }

    public function deleteLaporanPenjualan($id)
    {
        $data = TransaksiProduk::where('id',$id)->first();
        if ($data != null) {
            $data->delete();
            return redirect()->back()->withSuccess('Laporan Penjualan Berhasil Di hapus');
        }else{
            return redirect()->back()->withErrors('Data tidak ada');
        }
    }

    public function laporanJasa(Request $request)
    {
        $data = TransaksiJasa::with('user')->get();
        $laporan = [];
        $key_bulan = null;
        $key_range1 = null;
        $key_range2 = null;
        
        if ($request->select_bulan != null) {
            $key_bulan = $request->select_bulan;
            $b = date('m', strtotime($request->select_bulan));
            $t = date('Y', strtotime($request->select_bulan));
            $data = TransaksiJasa::with('user')->whereMonth('tanggal_transaksi_jasa',$b)->whereYear('tanggal_transaksi_jasa',$t)->get();    
            // dd($data);
        }

        if ($request->range_tanggal_start != null && $request->range_tanggal_end != null) {
            $key_range1 = $request->range_tanggal_start;
            $key_range2 = $request->range_tanggal_end;
            $m = date('Y-m-d', strtotime($request->range_tanggal_start));
            $s = date('Y-m-d', strtotime($request->range_tanggal_end));
            $data = TransaksiJasa::with('user')->whereBetween('tanggal_transaksi_jasa',[$m, $s])->get();    
        }

        $laporan = $data;
        return view('owner.laporan_jasa',compact('laporan'));
    }

    public function deletelaporanJasa($id)
    {
        $data = TransaksiJasa::where('id',$id)->first();
        if ($data != null) {
            $data->delete();
            return redirect()->back()->withSuccess('Laporan Jasa Berhasil Di hapus');
        }else{
            return redirect()->back()->withErrors('Data tidak ada');
        }
    }

    public function updateJasa(Request $request,$id)
    {
        try {
            // dd($request);
            $rules = [
                'nama_jasa'   => 'required|min:3|max:200',
                'harga_jasa'         => 'required|numeric',
            ];
            $message = [
                'nama_jasa.required'  => 'Nama jasa harus diisi',
                'harga_jasa.required'        => 'Harga jasa produk harus diisi',
                'harga_jasa.numeric'         => 'Harga jasa produk harus berupa angka',
            ];
            $validator = Validator::make($request->all(), $rules, $message);
    
            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
    
            // cek data by id
            $jasa = Jasa::where('id',$id)->first();
            // dd($fileName);
            $data = $jasa->update([
                'nama_jasa'   => $request->nama_jasa,
                'harga_jasa'         => $request->harga_jasa,
                // 'gambar_jasa' => $fileName,
            ]);
            return redirect()->back()->withSuccess('Data Jasa Sudah Di Ubah');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateFotoJasa(Request $request)
    {
        try {
            $data = Jasa::where('id',$request->id_jasa)->first();
            $folderPath = storage_path('app/public/jasa/');
            if (!file_exists($folderPath)) {
                Storage::disk('local')->makeDirectory('public/jasa/');
            }
            if (Storage::disk('local')->exists('public/jasa/' . $data->gambar_jasa)) {
                Storage::delete('public/jasa/' . $data->gambar_jasa);
            }
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $file = $folderPath . $fileName;

            file_put_contents($file, $image_base64);

            $data = Jasa::where('id',$request->id_jasa)->update([
                'gambar_jasa'   => $fileName,
            ]);
            return new JsonResponse(200, "Berhasil");
        } catch (\Throwable $th) {
            return new JsonResponse(500, $th->getMessage());
        }
    }

    public function settingProfile()
    {
        if (Auth::check() == true && auth()->user()->role == 2) {
            $user = DB::select('CALL getProfile(?)', array(auth()->user()->id));
            $data = new stdClass();
            $data = (object) $user[0];
            $prov = Provinsi::where('id',34)->first();
            return view('user.profile',compact('data','prov'));
        }else{
            return redirect()->route('login')->withErrors('Salah Server Pak');
        }
    }

    public function updateProfile(Request $request,$id)
    {
        try {
            $user = User::where('id',$id)->first();
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
                }if ($request->provinsi != null && $request->kabupaten != null && $request->kecamatan != null && $request->kelurahan && $request->detail_alamat != null) {
                    $alamat = new AlamatController;
                    $alamat = $alamat->updateAlamat($request,$user->id_alamat);
                }
                if ($request->detail_alamat != null) {
                    $alamat = new AlamatController;
                    $alamat = $alamat->updateDetailAlamat($request,$user->id_alamat);
                }
                $user->update($data);
                return redirect()->back()->withSuccess('Informasi Akun Sudah Di Ubah');
            }
        }  catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
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

    public function updatePassword(Request $request,$id)
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
            $user = User::where('id',$id)->first();
            $user->update([
                'password' => Hash::make($request->password), 
            ]);
            return redirect()->back()->withSuccess('Password berhasil di ubah');
        }  catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
