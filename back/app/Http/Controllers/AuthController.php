<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Provinsi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AlamatController;

class AuthController extends Controller
{
    public function index()
    {
        if ($user = Auth::user()) {
            if ($user->role == '2') {
                return redirect()->route('owner.index'); //owner
            }elseif($user->role == '1'){
                return redirect()->route('kasir.index'); //kasir
            }else if($user->role == '0'){
                return redirect()->route('guest.index'); // customer
            }
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $rules = [
                'email'     => 'required|email|exists:users',
                'password'  => 'required',
            ];
            $message = [
                'email.required'    => 'Email harus diisi',
                'email.email'       => 'Email tidak valid',
                'email.exists'      => 'Email tidak terdaftar',
                'password.required' => 'Password harus diisi',
            ];
            $validator = Validator::make($request->all(), $rules, $message);
            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            // cek login user
            $kredensial = request()->only('email','password');

            if (Auth::attempt($kredensial)) {
                $request->session()->regenerate();
                $user = Auth::user();
                // dd($user);
                if ($user->role == '2') {
                    return redirect()->route('owner.index')->withSuccess('Selamat Datang Owner');; //owner
                }elseif($user->role == '1'){
                    return redirect()->route('kasir.index')->withSuccess('Selamat Datang Kasir');; //kasir
                }else{
                    return redirect()->route('customer'); // customer
                }
                // return redirect()->route('home.login');
            }
            return redirect()->back()->withErrors("Username Atau Password Salah");

        }  catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function getFotoProfile($id)
    {
        try {
            $user = User::where('id',$id)->first();
            if($user == null){
                return null;
            }else{
                $img = Image::make(storage_path('app/public/profile/' . $user->foto_profile))->encode('data-url');
                if (isset($img)) {
                    return $img->encoded;
                }else{
                    return null;
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function register()
    {

        if ($user = Auth::user()) {
            if ($user->role == '2') {
                return redirect()->route('owner.index'); //owner
            }elseif($user->role == '1'){
                return redirect()->route('kasir.index'); //kasir
            }else if($user->role == '0'){
                return "ini guest"; // customer
            }
        }else{
            $user_admin = User::where('role',2)->count();
            if ($user_admin >= 1) {
                return redirect()->route('login')->withErrors("Account Owner Sudah Ada");
            }
            $prov = Provinsi::where('id',34)->first();
            return view('auth.register',compact('prov'));
        }
    }

    public function formRegister(Request $request)
    {
        // dd($request);
        try {
            $rules = [
                'nama_lengkap'  => 'required',
                'email'         => 'required',
                'gender'        => 'required',
                'no_telepon'    => 'required',
                'password'      => 'required',
                'provinsi'      => 'required',
                'kabupaten'     => 'required',
                'kecamatan'     => 'required',
                'kelurahan'     => 'required',
                'detail_alamat'  => 'required',
            ];
            $message = [
                'nama_lengkap.required'  => 'Nama lengkap harus diisi',
                'email.required'         => 'Email harus diisi',
                'gender.required'        => 'Gender harus diisi',
                'no_telepon.required'    => 'Nomor Telepon harus diisi',
                'password.required'      => 'Password harus diisi',
                'provinsi.required'      => 'Provinsi harus diisi',
                'kabupaten.required'     => 'Kabupaten harus diisi',
                'kecamatan.required'     => 'Kecamatan harus diisi',
                'kelurahan.required'     => 'Kelurahan harus diisi',
                'detail_alamat.required'  => 'Detail alamat harus diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $message);
 
            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            // add new alamat
            $alamat = new AlamatController;
            $alamat = $alamat->addAlamat($request);

            // add new user 
            $user = User::create([
                'nama_lengkap'=>$request->nama_lengkap,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'gender' => $request->gender,
                'no_telepon' => $request->no_telepon,
                'role' => 2,
                'id_alamat' => $alamat->id,
            ]);
            return redirect()->route('login')->withSuccess('Register Berhasil');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function forgetPassword()
    {
        return view('auth.forgot_password');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ],[
            'email.required'    => 'Email Harus Diisi',
            'email.email'       => 'Email Tidak Valid',
            'email.exists'      => 'Email Tidak Terdaftar'
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        $link = 'http://127.0.0.1:8000/reset-password/'.$token;

        Mail::send('email.reset_pass', ['link' => $link], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });
        return redirect()->back()->withSuccess('Kami Sudah Mengirim Link Untuk Reset Password Anda');
    }

    public function resetPassword($token)
    {
        return view('auth.update_password',compact('token'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ],[
           'email.required'                 => 'Email harus diisi',
           'email.email'                    => 'Email tidak valid',
           'email.exists'                   => 'Email tidak terdaftar',
           'password.required'              => 'Password harus diisi',
           'password.min'                   => 'Password minimal perpaduan 6 digit huruf dengan angka',
           'password.confirmed'             => 'Konfirmasi password tidak sama',
           'password_confirmation.required' => 'Konfirmasi password harus diisi',
        ]);
        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])->first();
        
        if(!$updatePassword){
            return redirect()->back()->withErrors('Invalid token!');
        }
        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        
        return redirect()->route('login')->withSuccess('Password anda berhasil di ubah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
