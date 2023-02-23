<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Jasa;
use App\Models\Produk;
use App\Models\Grooming;
use App\Models\Penitipan;
use Illuminate\Http\Request;
use App\Models\TransaksiJasa;
use App\Models\TransaksiProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\Detail_Transaksi_Produk;

class PDFController extends Controller
{
    public function printNotaPembayaranProduk(Request $request)
    {
        if (Auth::check() == true && auth()->user()->role == 1) {

            $nama_kasir = auth()->user()->nama_lengkap;
            $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
            // dd($now);
            $total_harga = 0;
            $keranjang = Detail_Transaksi_Produk::all();
            foreach ($keranjang as $key => $value) {
                $keranjang[$key]->harga_total = $keranjang[$key]->harga * $keranjang[$key]->jumlah_barang;
                $total_harga += $keranjang[$key]->harga_total;
            }
            $id_transaksi = $request->id_transaksi;
            $user_bayar = $request->user_membayar;
            $kembalian = $request->kembalian;
            $detail = $keranjang;
            $fileName = $request->id_transaksi . '.pdf';

            DB::select('CALL resetKeranjang()');
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])
                ->loadview(
                    'pdf.nota_transaksi_produk',
                    compact('detail', 'total_harga', 'id_transaksi', 'tanggal', 'nama_kasir', 'user_bayar', 'kembalian')
                );
            $pdf->download($fileName);
            return $pdf->stream();
            // return $pdf->download($fileName);
            // return view('pdf.nota_transaksi_produk',compact('detail','total_harga'));
        } else {
            return redirect()->back()->withErrors('Salah Server Pak');
        }
    }

    public function printNotaPembayaranJasa(Request $request,$tanggal,$noInvoice,$pembayaran)
    {
        // dd([$request,$tanggal,$noInvoice,$pembayaran]);
        if (Auth::check() == true && auth()->user()->role == 1) {
            $kasir = auth()->user()->nama_lengkap;
            $customer = DB::select('CALL getProfile(?)', array($request->pemilik));
            $customer = (object) $customer[0];
            $tglTransaksi = $tanggal;
            
            $totalBayar = $request->total_bayar;
            $user_membayar = $request->user_membayar;
            $kembalian = $request->kembalian;

            foreach ($pembayaran as $key => $value) {
                if ($pembayaran[$key]->id_jasa == 3 || $pembayaran[$key]->id_jasa == 2) {
                    $gro = Grooming::where('id_hewan',$pembayaran[$key]->id_hewan)->first();
                    $pembayaran[$key]->waktu_masuk = $gro->waktu_masuk;
                    $pembayaran[$key]->waktu_keluar = $gro->waktu_keluar;
                    $pembayaran[$key]->tanggal_grooming = $gro->tanggal_grooming;
                }else{
                    $titip = Penitipan::where('id_hewan',$pembayaran[$key]->id_hewan)->where('is_selesai',1)->first();
                    $pembayaran[$key]->tanggal_masuk = $titip->tanggal_masuk;
                    $pembayaran[$key]->tanggal_keluar = $titip->tanggal_keluar;
                }
            }

            foreach ($pembayaran as $key => $value) {
                if ($pembayaran[$key]->id_jasa == 3 || $pembayaran[$key]->id_jasa == 2) {
                    Grooming::where('id_hewan',$pembayaran[$key]->id_hewan)->delete();
                }else{
                    Penitipan::where('id_hewan',$pembayaran[$key]->id_hewan)->where('is_selesai',1)->delete();
                }
            }
            // dd($pembayaran);
            $fileName = $noInvoice . '.pdf';
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])
                ->loadview(
                    'pdf.nota_transaksi_jasa',
                    compact('noInvoice','kasir','customer','tanggal','fileName','pembayaran','totalBayar','user_membayar','kembalian')
                );
            // $pdf->download($fileName);
            // return $pdf->stream();
            return $pdf->download($fileName);
            // return view('pdf.nota_transaksi_jasa',compact('noInvoice','kasir','customer','tanggal','fileName','pembayaran','totalBayar','user_membayar','kembalian'));
        }else{
            dd("error");
            return redirect()->back()->withErrors('Salah Server Pak');
        }
    }

    public function exportPDFProdukAnjing()
    {
        if (Auth::check() == true && auth()->user()->role == 1) {
            $nama_kasir = auth()->user()->nama_lengkap;
            $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
            $fileName = 'Data Produk Pertanggal ' . $tanggal . '.pdf';

            $data = Produk::where('kode_produk', 'like', '%PA%')->get();
            foreach ($data as $key => $value) {
                if ($data[$key]->gambar_produk != null) {
                    $data[$key]->gambar_produk = $this->getFoto($data[$key]->gambar_produk);
                }
            }
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])->loadview('pdf.laporan_produk', compact('data', 'tanggal', 'fileName', 'tanggal'))->setPaper('a4', 'landscape');
            // return $pdf->stream();
            return $pdf->download($fileName);
        } else {
            return redirect()->back()->withErrors('Salah Server Pak');
        }
    }

    public function exportPDFProdukKucing()
    {
        if (Auth::check() == true && auth()->user()->role == 1) {
            $nama_kasir = auth()->user()->nama_lengkap;
            $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
            $fileName = 'Data Produk Pertanggal ' . $tanggal . '.pdf';

            $data = Produk::where('kode_produk', 'like', '%PK%')->get();
            foreach ($data as $key => $value) {
                if ($data[$key]->gambar_produk != null) {
                    $data[$key]->gambar_produk = $this->getFoto($data[$key]->gambar_produk, 'produk');
                }
            }
            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])->loadview('pdf.laporan_produk', compact('data', 'tanggal', 'fileName', 'tanggal'))->setPaper('a4', 'landscape');
            // return $pdf->stream();
            return $pdf->download($fileName);
        } else {
            return redirect()->back()->withErrors('Salah Server Pak');
        }
    }

    public function exportPDFTransaksiProduk(Request $request)
    {
        if (Auth::check() == true && auth()->user()->role == 2) {
            $nama_owner = auth()->user()->nama_lengkap;
            $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
            $fileName = 'Data Penjualan Produk Pertanggal ' . $tanggal . '.pdf';

            if ($request->filter_bulan_pdf) {
                $b = date('m', strtotime($request->filter_bulan_pdf));
                $t = date('Y', strtotime($request->filter_bulan_pdf));
                $data = TransaksiProduk::with('user')->whereMonth('tanggal_transaksi_produk', $b)->whereYear('tanggal_transaksi_produk', $t)->get();
            } else if ($request->filter_range1_pdf != null && $request->filter_range2_pdf != null) {
                $m = date('Y-m-d', strtotime($request->filter_range1_pdf));
                $s = date('Y-m-d', strtotime($request->filter_range2_pdf));
                $data = TransaksiProduk::with('user')->whereBetween('tanggal_transaksi_produk', [$m, $s])->get();
            } else {
                $data = TransaksiProduk::with('user')->get();
            }

            if (empty($data)) {
                return redirect()->back()->withErrors('Export gagal');
            }

            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])
                ->loadview('pdf.laporan_transaksi_produk', compact('data', 'tanggal', 'fileName'))->setPaper('a4', 'landscape');
            // return $pdf->stream();
            return $pdf->download($fileName);
            // return view('pdf.laporan_transaksi_produk',compact('data','fileName','tanggal'));
        } else {
            return redirect()->back()->withErrors('Salah Server Pak');
        }
    }

    public function exportPDFTransaksiJasa(Request $request)
    {
        if (Auth::check() == true && auth()->user()->role == 2) {
            $nama_owner = auth()->user()->nama_lengkap;
            $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
            $fileName = 'Data Transaksi Jasa Pertanggal ' . $tanggal . '.pdf';

            if ($request->filter_bulan_pdf) {
                $b = date('m', strtotime($request->filter_bulan_pdf));
                $t = date('Y', strtotime($request->filter_bulan_pdf));
                $data = TransaksiJasa::with('user')->whereMonth('tanggal_transaksi_jasa', $b)->whereYear('tanggal_transaksi_jasa', $t)->get();
            } else if ($request->filter_range1_pdf != null && $request->filter_range2_pdf != null) {
                $m = date('Y-m-d', strtotime($request->filter_range1_pdf));
                $s = date('Y-m-d', strtotime($request->filter_range2_pdf));
                $data = TransaksiJasa::with('user')->whereBetween('tanggal_transaksi_jasa', [$m, $s])->get();
            } else {
                $data = TransaksiJasa::with('user')->get();
            }

            if (empty($data)) {
                return redirect()->back()->withErrors('Export gagal');
            }

            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])
                ->loadview('pdf.laporan_transaksi_jasa', compact('data', 'tanggal', 'fileName'))->setPaper('a4', 'landscape');
            // return $pdf->stream();
            return $pdf->download($fileName);
            // return view('pdf.laporan_transaksi_produk',compact('data','fileName','tanggal'));
        } else {
            return redirect()->back()->withErrors('Salah Server Pak');
        }
    }

    public function exportPDFCustomer()
    {
        if (Auth::check() == true && auth()->user()->role == 1) {
            $nama_kasir = auth()->user()->nama_lengkap;
            $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
            $fileName = 'Data Customer Pertanggal ' . $tanggal . '.pdf';

            $data = DB::select('CALL getCustomer()');
            foreach ($data as $key => $value) {
                if ($data[$key]->detail_alamat != null) {
                    $data[$key]->alamat = self::mergeAlamat($data[$key]->detail_alamat, $data[$key]->provinsi, $data[$key]->kabupaten, $data[$key]->kecamatan, $data[$key]->kelurahan);
                }
                if ($data[$key]->gambar_hewan != null) {
                    $data[$key]->gambar_hewan = $this->getFoto($data[$key]->gambar_hewan, 'hewan');
                }
            }
            // dd($data);

            $pdf = PDF::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])
                ->loadview('pdf.laporan_customer', compact('data', 'tanggal', 'fileName', 'tanggal'))->setPaper('a4', 'landscape');
            // return $pdf->stream();
            return $pdf->download($fileName);
            // return view('pdf.laporan_customer', compact('data', 'fileName', 'tanggal'));
        } else {
            return redirect()->back()->withErrors('Salah Server Pak');
        }
    }

    private function getFoto($file, $destinasi)
    {
        try {
            $img = Image::make(storage_path('app/public/' . $destinasi . '/' . $file))->encode('data-url');
            if (isset($img)) {
                return $img->encoded;
            }
            return null;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function mergeAlamat($detail_alamat, $provinsi, $kabupaten, $kecamatan, $kelurahan)
    {
        try {
            return $detail_alamat . ', ' . $provinsi . ', ' . $kabupaten . ', ' . $kecamatan . ', ' . $kelurahan;
        } catch (\Throwable $th) {
            return '-';
        }
    }
}
