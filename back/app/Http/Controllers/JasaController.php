<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jasa;
use App\Models\User;
use App\Models\Hewan;
use App\Models\Grooming;
use App\Models\Penitipan;
use Nette\Utils\DateTime;
use Illuminate\Http\Request;
use App\Models\TransaksiJasa;
use App\Models\Transaksi_Jasa;
use App\Models\Pembayaran_Jasa;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JsonResponse;
use Illuminate\Support\Facades\Validator;

class JasaController extends Controller
{

    public function grooming_penitipan()
    {
        $grooming = Jasa::where('nama_jasa', 'LIKE', '%Grooming%')->get();
        $userHewan = DB::select('CALL getUserHewanAll()');
        return view('kasir.grooming_penitipan',compact('grooming','userHewan'));
    }

    public function saveGroomingPenitipan(Request $request)
    {
        // dd($request);
        Grooming::create([
            'id_jasa'           => $request->jenis_grooming,
            'id_hewan'          => $request->id_hewan,
            'tahapan'           => "Pendataan",
            'tanggal_grooming'  => date('Y-m-d', strtotime($request->tanggal)),
            'waktu_masuk'       => date('H:i', strtotime($request->waktu_masuk)),
            'waktu_keluar'      => date('H:i', strtotime($request->waktu_keluar)),
        ]);

        Penitipan::create([
            'id_hewan' => $request->id_hewan,
            'id_jasa' => 1,
            'no_kandang' => $request->nomor_kandang,
            'tanggal_masuk' => date('Y-m-d H:i:s', strtotime($request->tanggal)),
            'tanggal_keluar' => date('Y-m-d H:i:s', strtotime($request->tanggal_keluar)),
        ]);
        return redirect()->back()->withSuccess('Hewan Berhasil Di Tambahkan Ke Grooming Dan Penitipan');
    }

    public function grooming()
    {
        $jasa = Jasa::where('nama_jasa', 'LIKE', '%Grooming%')->get();
        $userHewan = DB::select('CALL getUserHewanAll()');
        $grooming = DB::select('CALL getGroomingAll()');
        $id_transaksi = rand(1000000000, 9999999999);
        // dd($grooming);
        return view('kasir.grooming', compact('userHewan', 'id_transaksi', 'jasa', 'grooming'));
    }

    public function saveGrooming(Request $request)
    {
        // dd($request);
        try {
            $data = Grooming::create([
                'id_jasa'           => $request->jenis_grooming,
                'id_hewan'          => $request->id_hewan,
                'tahapan'           => "Pendataan",
                'tanggal_grooming'  => date('Y-m-d', strtotime($request->tanggal)),
                'waktu_masuk'       => date('H:i', strtotime($request->waktu_masuk)),
                'waktu_keluar'      => date('H:i', strtotime($request->waktu_keluar)),
            ]);
            return redirect()->back()->withSuccess('Data berhasil di tambahkan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updateGrooming(Request $request, $id)
    {
        try {
            $data = [];
            if ($request->tahapan != null) {
                $data['tahapan'] = $request->tahapan;
            }
            if ($request->waktu_keluar != null) {
                $data['waktu_keluar'] = date('H:i', strtotime($request->waktu_keluar));
            }
            $grom = Grooming::where('id', $id)->first();
            $grom->update($data);
            return redirect()->back()->withSuccess('Data Berhasil Diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function groomingDelete($id)
    {
        $data = Grooming::where('id', $id)->first();
        if ($data != null) {
            $data->delete();
            return redirect()->back()->withSuccess('Data Berhasil Dihapus');
        } else {
            return redirect()->back()->withErrors('Tidak Ada Data');
        }
    }

    public function getDetailBayar($id)
    {
        try {
            $data = DB::select('CALL getDetailBayar(?)', array($id));
            $count = Hewan::where('id_user', $id)
                ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')
                ->join('users', 'users.id', '=', 'hewan.id_user')->get('pembayaran_jasa.*')->count();
            if (empty($data)) {
                return new JsonResponse(400, "Tidak ada data");
            } else {
                $total = 0;
                if ($count > 1) {
                    foreach ($data as $x => $value) {
                        if ($data[$x]->nama_jasa == "Penitipan") {
                            $data[$x]->harga_jasa = $data[$x]->harga_jasa * $data[$x]->durasi;
                        }
                        $total +=  $data[$x]->harga_jasa;
                    }
                } else if ($count == 1) {
                    if ($data[0] == "Penitipan") {
                        $data[0]->harga_jasa = $data[0]->harga_jasa * $data[0]->durasi;
                    } else {
                        $data[0]->harga_jasa;
                    }
                    $total += $data[0]->harga_jasa;
                }
                $res = [];
                $res['total'] = $total;
                $res['detailBayar'] = $data;
                return new JsonResponse(200, "Data ditemukan", $res);
            }
        } catch (\Throwable $th) {
            return new JsonResponse(400, $th->getMessage());
        }
    }

    public function transaksiJasa()
    {
        $tagihan = DB::select('CALL getTagihanPembayaran()');
        foreach ($tagihan as $key => $value) {
            $tagihan[$key]->nama_pemilik = $this->getNamaPemilik($tagihan[$key]->pemilik);
            $tagihan[$key]->nama_hewan = $this->getNamaHewan($tagihan[$key]->pemilik);
            $tagihan[$key]->total_bayar = $this->getTotalHarga($tagihan[$key]->pemilik);
            // dd($tagihan[$key]->total_bayar);
        }
        return view('transaksi.transaksi_jasa', compact('tagihan'));
    }

    public function pembayaranJasa(Request $request)
    {
        // dd($request);
        $data = DB::select('CALL getDetailBayar(?)', array($request->pemilik));
        $count = Hewan::where('id_user', $request->pemilik)
            ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')
            ->join('users', 'users.id', '=', 'hewan.id_user')->get('pembayaran_jasa.*')->count();
        if (empty($data)) {
            return redirect()->back()->withErrors('Gagal Transaksi');
        } else {
            $total = 0;
            if ($count > 1) {
                foreach ($data as $x => $value) {
                    if ($data[$x]->nama_jasa == "Penitipan") {
                        $data[$x]->harga_jasa = $data[$x]->harga_jasa * $data[$x]->durasi;
                    } else {
                        continue;
                    }
                }
            } else if ($count == 1) {
                if ($data[0] == "Penitipan") {
                    $data[0]->harga_jasa = $data[0]->harga_jasa * $data[0]->durasi;
                } else {
                    $data[0]->harga_jasa;
                }
            }
        }

        // dd($data);
        $id_transaksi = rand(1000000000, 9999999999);

        $tanggal = Carbon::now();
        $d = date('Y-m-d H:i:s', strtotime($tanggal));
        if ($count > 1) {
            foreach ($data as $key => $value) {
                TransaksiJasa::create([
                    'kode_transaksi_jasa' => $id_transaksi,
                    'kasir_id'  => auth()->user()->id,
                    'id_hewan'  => $data[$key]->id_hewan,
                    'jasa_id'   => $data[$key]->id_jasa,
                    'tanggal_transaksi_jasa'    => $d,
                    'total_harga_jasa'  => $data[$key]->harga_jasa,
                    'is_bayar'  => 1,
                ]);
            }
        } else if ($count == 1) {
            TransaksiJasa::create([
                'kode_transaksi_jasa' => $id_transaksi,
                'kasir_id'  => auth()->user()->id,
                'id_hewan'  => $data[0]->id_hewan,
                'jasa_id'   => $data[0]->id_jasa,
                'tanggal_transaksi_jasa'    => $d,
                'total_harga_jasa'  => $data[0]->harga_jasa,
                'is_bayar'  => 1,
            ]);
        }

        // delete pembayaran
        foreach ($data as $value) {
            DB::table('pembayaran_jasa')->where(['id_hewan' => $value->id_hewan])->delete();
        }
        $nota = new PDFController();
        return $nota->printNotaPembayaranJasa($request, $d, $id_transaksi, $data);
    }

    private function getNamaPemilik($id)
    {
        $data = User::where('id', $id)->first();
        return $data->nama_lengkap;
    }

    private function getNamaHewan($id)
    {
        $nama = '';
        $hewan = Hewan::where('id_user', $id)
            ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')->get();
        $count = Hewan::where('id_user', $id)
            ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')->get()->count();
        if ($count > 1) {
            foreach ($hewan as $value) {
                $nama .= $value->nama_hewan . ',';
            }
        } else {
            $nama = $hewan[0]->nama_hewan;
        }
        return $nama;
    }

    private function getJasaPakai($id)
    {
        $jasa = '';
        $hewan = Hewan::where('id_user', $id)
            ->join('grooming', 'grooming.id_hewan', '=', 'hewan.id_hewan')
            ->join('jasa', 'jasa.id', '=', 'grooming.id_jasa')->get('jasa.nama_jasa');
        $count = Hewan::where('id_user', $id)
            ->join('grooming', 'grooming.id_hewan', '=', 'hewan.id_hewan')
            ->join('jasa', 'jasa.id', '=', 'grooming.id_jasa')->get('jasa.nama_jasa')->count();
        if ($count > 1) {
            foreach ($hewan as $value) {
                $jasa .= $value->nama_jasa . ',';
            }
        } else {
            $jasa .= $hewan[0]->nama_jasa;
        }
        return $jasa;
    }

    private function getTotalHarga($id)
    {
        $harga = 0;
        $penitipan = $this->harga_penitipan($id);
        // return $penitipan;
        $grooming = $this->harga_grooming($id);
        // return $grooming;
        $harga = $penitipan + $grooming;
        return $harga;
    }

    private function harga_penitipan($id)
    {
        $harga = 0;
        $durasi = Hewan::where('id_user', $id)
            ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')
            ->join('jasa', 'jasa.id', '=', 'pembayaran_jasa.id_jasa')->where('jasa.id', 1)->get();
        $durasiCount = Hewan::where('id_user', $id)
            ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')
            ->join('jasa', 'jasa.id', '=', 'pembayaran_jasa.id_jasa')->where('jasa.id', 1)->get()->count();
        // dd($durasi);

        if ($durasiCount > 1) {
            foreach ($durasi as $key => $value) {
                $harga += ($durasi[$key]->harga_jasa * $durasi[$key]->durasi);
            }
        } else if ($durasiCount == 1) {
            $harga += $durasi[0]->harga_jasa * $durasi[0]->durasi;
        }
        return $harga;
    }

    private function harga_grooming($id)
    {
        $harga = 0;
        $hewan = Hewan::where('id_user', $id)->where('id_jasa', 2)->orWhere('id_jasa', 3)
            ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')
            ->join('jasa', 'jasa.id', '=', 'pembayaran_jasa.id_jasa')->get();
        // return $hewan;
        $count = Hewan::where('id_user', $id)->where('id_jasa', 2)->orWhere('id_jasa', 3)
            ->join('pembayaran_jasa', 'pembayaran_jasa.id_hewan', '=', 'hewan.id_hewan')
            ->join('jasa', 'jasa.id', '=', 'pembayaran_jasa.id_jasa')->get()->count();
        // dd($count);
        if ($count > 1) {
            foreach ($hewan as $value) {
                $harga += $value->harga_jasa;
            }
        } else if ($count == 1) {
            $harga += $hewan[0]->harga_jasa;
        }
        return $harga;
    }

    public function groomingSelesai($id)
    {
        try {
            $data = Grooming::where('id', $id)->first();
            $jasa = Jasa::where('id', $data->id_jasa)->first();
            if ($data != null) {
                $bayar = Pembayaran_Jasa::create([
                    'id_hewan'  => $data->id_hewan,
                    'id_jasa'   => $data->id_jasa,
                ]);
                // update
                $data->update([
                    "tahapan"   => "Selesai",
                ]);
            }
            return redirect()->back()->withSuccess('Data Berhasil Diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function getJasa($id)
    {
        $data = Jasa::where('id', $id)->first();
        if ($data != null) {
            return new JsonResponse(200, "Data ditemukan", $data);
        } else {
            return new JsonResponse(400, "Tidak ada data");
        }
    }


    // PENITIPAN
    public function penitipan()
    {
        $data = DB::select('CALL getUserHewanAll');
        $penitipanAll = DB::select('CALL getPenitipanAll()');
        // dd($data);
        if ($penitipanAll != null) {
            foreach ($penitipanAll as $key => $value) {
                $tanggalMasuk = new DateTime($penitipanAll[$key]->tanggal_masuk);
                $tanggalKeluar = new DateTime($penitipanAll[$key]->tanggal_keluar);
                if ($this->cekDurasi($tanggalMasuk, $tanggalKeluar) == '0') {
                    $durasiAngka = $this->cekDurasi($tanggalMasuk, $tanggalKeluar) + 1;
                    $durasi = ($this->cekDurasi($tanggalMasuk, $tanggalKeluar) + 1) . ' hari';
                    $harga = ($this->cekDurasi($tanggalMasuk, $tanggalKeluar) + 1) * $penitipanAll[$key]->harga_jasa;
                } else {
                    $durasiAngka = $this->cekDurasi($tanggalMasuk, $tanggalKeluar);
                    $durasi = $this->cekDurasi($tanggalMasuk, $tanggalKeluar) . ' hari';
                    $harga = $this->cekDurasi($tanggalMasuk, $tanggalKeluar) * $penitipanAll[$key]->harga_jasa;
                }
                $penitipanAll[$key]->durasi = $durasi;
                $penitipanAll[$key]->durasiAngka = $durasiAngka;
                $penitipanAll[$key]->hargaPenitipanTotal = 'Rp ' . number_format($harga, 2, ",", ".");
                // dd($penitipanAll);
            }
        }
        // dd($penitipanAll);
        return view('kasir.penitipan', compact('data', 'penitipanAll'));
    }

    private function cekDurasi($tglAwal, $tglAkhir)
    {
        $temp = $tglAwal->diff($tglAkhir);
        // echo $temp;
        // $hasil = floor($temp/(60 * 60 * 24));
        // return $hasil;
        return $temp->format('%a');
    }

    public function getUser($id)
    {
        $data = Hewan::where('id_hewan', $id)->first();
        if ($data == null) {
            return new JsonResponse(404, "Tidak ada data");
        }
        $user = User::where('id', $data->id_user)->first();
        return new JsonResponse(200, "Data ditemukan", $user->nama_lengkap);
    }

    public function savePenitipan(Request $request)
    {
        // dd($request);
        try {
            $rules = [
                'id_hewan' => 'required',
                'tanggal_masuk' => 'required',
                'tanggal_keluar' => 'required',
                'nomor_kandang' => 'required'
            ];
            $message = [
                'id_hewan.required'  => 'Nama hewan harus diisi',
                'tanggal_masuk.required'  => 'Tanggal Masuk harus diisi',
                'tanggal_keluar.required'  => 'Tanggal Keluar harus diisi',
                'nomor_kandang.required'  => 'Nomor Kandang harus diisi'
            ];
            $validator = Validator::make($request->all(), $rules, $message);
            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            $data = Penitipan::create([
                'id_hewan' => $request->id_hewan,
                'id_jasa' => 1,
                'no_kandang' => $request->nomor_kandang,
                'tanggal_masuk' => date('Y-m-d H:i:s', strtotime($request->tanggal_masuk)),
                'tanggal_keluar' => date('Y-m-d H:i:s', strtotime($request->tanggal_keluar)),
            ]);
            return redirect()->back()->withSuccess('Data Penitipan Berhasil Di Tambahkan');
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function updatePenitipan(Request $request, $id)
    {
        try {
            // dd($id);
            $rules = [
                'no_kandang'        => 'required',
                // 'tanggal_masuk'        => 'required',
                'tanggal_keluar'        => 'required',
            ];
            $message = [
                'no_kandang.required'         => 'Nomor Kandang harus diisi',
                // 'tanggal_masuk.required'        => 'Tanggal Masuk harus diisi',
                'tanggal_keluar.required'         => 'Tanggal Ambil harus diisi',
            ];
            $validator = Validator::make($request->all(), $rules, $message);

            //cek validasi
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            // cek data by id
            $penitipan = Penitipan::where('id', $id)->first();
            // dd($penitipan);

            $data = $penitipan->update([
                'no_kandang'        => $request->no_kandang,
                // 'tanggal_masuk' => date('Y-m-d H:i:s', strtotime($request->tanggal_masuk)),
                'tanggal_keluar' => date('Y-m-d H:i:s', strtotime($request->tanggal_keluar)),
            ]);
            return redirect()->back()->withSuccess('Data Penitipan Berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function deletePenitipan($id)
    {
        try {
            $data = Penitipan::where('id', $id)->first();
            // if (Storage::disk('local')->exists('public/produk/'.$data->gambar_produk)) {
            //     Storage::delete('public/produk/' . $data->gambar_produk);
            // }
            if ($data == null) {
                return redirect()->back()->withErrors('Data Penitipan Tidak Ditemukan');
            } else {
                $data->delete();
                return redirect()->back()->withSuccess('Data Penitipan Berhasil Dihapus');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function penitipanSelesai($id, $durasi)
    {
        // dd($durasi);
        try {
            $data = Penitipan::where('id', $id)->first();
            $jasa = Jasa::where('id', $data->id_jasa)->first();
            // dd($jasa);
            if ($data != null) {
                $bayar = Pembayaran_Jasa::create([
                    'id_hewan'  => $data->id_hewan,
                    'id_jasa'   => $data->id_jasa,
                    'durasi'    => $durasi,
                ]);
                $data->update([
                    'is_selesai' => 1,
                ]);
            }
            return redirect()->back()->withSuccess('Data Berhasil Diubah');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // public function selesaiPenitipan($id){
    //     $data = Penitipan::where('id', $id)->first();
    //     try {            
    //         $rules = [
    //             'id_hewan' => 'required',
    //             'tanggal_masuk' => 'required',
    //             'tanggal_keluar' => 'required',
    //             'nomor_kandang' => 'required'
    //         ];
    //         $message = [
    //             'id_hewan.required'  => 'Nama hewan harus diisi',
    //             'tanggal_masuk.required'  => 'Tanggal Masuk harus diisi',
    //             'tanggal_keluar.required'  => 'Tanggal Keluar harus diisi',
    //             'nomor_kandang.required'  => 'Nomor Kandang harus diisi'
    //         ];
    //         $validator = Validator::make($request->all(), $rules, $message);
    //         //cek validasi
    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput($request->all());
    //         }

    //         $data = TransaksiJasa::create([
    //             'id_hewan'=>$request->id_hewan,
    //             'id_jasa'=>1,
    //             'no_kandang'=>$request->nomor_kandang,
    //             'tanggal_masuk'=>date('Y-m-d H:i:s',strtotime($request->tanggal_masuk)),
    //             'tanggal_keluar'=>date('Y-m-d H:i:s',strtotime($request->tanggal_keluar)),
    //         ]);
    //         return redirect()->back()->withSuccess('Data Penitipan Berhasil Di Tambahkan');

    //     } catch (\Throwable $th) {
    //         // dd($th->getMessage());
    //         return redirect()->back()->withErrors($th->getMessage());
    //     }
    // }
}
