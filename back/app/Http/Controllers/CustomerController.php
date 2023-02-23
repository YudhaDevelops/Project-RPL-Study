<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::check() == true && auth()->user()->role == 0) {
            $data = DB::select('CALL cekPenggunaanJasa(?)', array(auth()->user()->id));
            if (empty($data)) {
                return redirect()->route('landing');
            } else {
                return redirect()->route('guest.infoPet');
            }
        } else {
            return redirect()->route('landing');
        }
    }

    public function infoPet()
    {
        $groming = DB::select('CALL getGroomingByUser(?)', array(auth()->user()->id));
        if (empty($groming)) {
            $groming = null;
        }
        $penitipan = DB::select('CALL getPenitipanByUser(?)', array(auth()->user()->id));
        if (empty($penitipan)) {
            $penitipan = null;
        }
        return view('customer.info_pet', compact('groming', 'penitipan'));
    }

    public function infoPetDetailGroming($id_grooming, $id_hewan)
    {
        $data = DB::select('CALL getDetailInfoGrooming(?,?)', array($id_grooming, $id_hewan));
        if (empty($data)) {
            $data = null;
        } else {
            $data = (object) $data[0];
            $gambar = self::getFoto($data->gambar_hewan);
        }
        return view('customer.detail_info_pet_grooming', compact('data','gambar'));
    }
    public function infoPetDetailPenitipan($id_penitipan, $id_hewan)
    {
        $data = DB::select('CALL getDetailInfoPenitipan(?,?)', array($id_penitipan, $id_hewan));
        if (empty($data)) {
            $data = null;
        } else {
            $data = (object) $data[0];
            $harga = ($this->cekDurasi($data->tanggal_masuk, $data->tanggal_keluar) + 1) * $data->harga_jasa;
            $gambar = self::getFoto($data->gambar_hewan);
        }
        return view('customer.detail_info_pet_penitipan', compact('data', 'harga','gambar'));
    }

    private function getFoto($file)
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

    private function cekDurasi($tglAwal, $tglAkhir)
    {
        $tanggalMasuk = new DateTime($tglAwal);
        $tanggalKeluar = new DateTime($tglAkhir);
        $temp = $tanggalMasuk->diff($tanggalKeluar);
        return $temp->format('%a');
    }

    public function gantiPassword()
    {
        if (Auth::check() == true && auth()->user()->role == 0) {
            $user = User::where('id', auth()->user()->id)->first();
            return view('customer.edit_pass_customer', compact('user'));
        } else {
            return redirect()->route('landing')->withErrors('Salah Server Pak');
        }
    }

    public function customerGantiPassword(Request $request)
    {
        // dd($request);
        try {
            $rules = [
                'email'         => 'required|email|exists:users',
                'password'              => 'required|string',
                'pass_baru'              => 'required|confirmed'
            ];
            $message = [
                'email.required'                 => 'Email harus diisi',
                'email.email'                    => 'Email tidak valid',
                'email.exists'                   => 'Email tidak terdaftar',
                'password.required'     => 'Password Lama wajib diisi',
                'password.string'       => 'Password Lama harus berupa string',
                'pass_baru.required'     => 'Password Baru wajib diisi',
                'pass_baru.confirmed'    => 'Password Baru tidak sama dengan konfirmasi password baru'
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            $kredensial = request()->only('email', 'password');
            if (Auth::attempt($kredensial)) {
                $user = User::where('id', auth()->user()->id)->first();
                $user->update([
                    'password' => Hash::make($request->pass_baru),
                ]);
                return redirect()->back()->withSuccess('Update Passoword Berhasil');
            } else {
                return redirect()->back()->withErrors('Password Lama Yang Anda Masukkan Salah');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
