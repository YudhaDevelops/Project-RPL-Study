<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\TransaksiJasa;
use App\Models\TransaksiProduk;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelController extends Controller
{
    public function exportProdukSemua()
    {
        $role = auth()->user()->role;
        if(!isset($role) && $role == 0){
            return redirect()->back()->withErrors(['msg' => 'export gagal']);
        }
        $filename = 'Data Produk Anjing.xlsx';
        $p = Produk::all();
        $data = self::beautifyDataProduk($p);
        $KOLOM = [
            'ID', 'Kode Produk', 'Nama Produk',
            'Bobot/gram','Harga', 'Stok', 'Gambar Produk',
        ];
        array_unshift($data, $KOLOM);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Team 7 | Zoepy Petshop")
            ->setLastModifiedBy(auth()->user()->nama_lengkap)
            ->setTitle("Data Semua Produk")
            ->setSubject("Data Semua Produk")
            ->setDescription("Data Keseluruhan Produk");
        $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $data,
                'A1'
            );
        for ($i = 'A'; $i !=  'H'; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    public function exportProdukAnjing()
    {
        $role = auth()->user()->role;
        if(!isset($role) && $role == 0){
            return redirect()->back()->withErrors(['msg' => 'export gagal']);
        }
        $filename = 'Data Produk Anjing.xlsx';
        $p = Produk::where('kode_produk', 'like', '%PA%')->get();
        $data = self::beautifyDataProduk($p);
        $KOLOM = [
            'ID', 'Kode Produk', 'Nama Produk',
            'Bobot/gram','Harga', 'Stok', 'Gambar Produk',
        ];
        array_unshift($data, $KOLOM);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Team 7 | Zoepy Petshop")
            ->setLastModifiedBy(auth()->user()->nama_lengkap)
            ->setTitle("Data Produk Anjing")
            ->setSubject("Data Produk Anjing")
            ->setDescription("Data Keseluruhan Produk");
        $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $data,
                'A1'
            );
        for ($i = 'A'; $i !=  'H'; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    public function exportProdukKucing()
    {
        $role = auth()->user()->role;
        if(!isset($role) && $role == 0){
            return redirect()->back()->withErrors(['msg' => 'export gagal']);
        }
        $filename = 'Data Produk Kucing.xlsx';
        
        $p = Produk::where('kode_produk', 'like', '%PK%')->get();
        $data = self::beautifyDataProduk($p);
        $KOLOM = [
            'ID', 'Kode Produk', 'Nama Produk',
            'Bobot/gram','Harga', 'Stok', 'Gambar Produk',
        ];
        array_unshift($data, $KOLOM);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Team 7 | Zoepy Petshop")
            ->setLastModifiedBy(auth()->user()->nama_lengkap)
            ->setTitle("Data Produk Kucing")
            ->setSubject("Data Produk Kucing")
            ->setDescription("Data Keseluruhan Produk");
        $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $data,
                'A1'
            );
        for ($i = 'A'; $i !=  'H'; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    public function exportTransaksiProduk(Request $request)
    {
        $role = auth()->user()->role;
        if(!isset($role) && $role == 0){
            return redirect()->back()->withErrors('Export gagal');
        }
        $filename = 'Data Transaksi Produk.xlsx';
        
        if ($request->filter_bulan_xls) {
            $b = date('m', strtotime($request->filter_bulan_xls));
            $t = date('Y', strtotime($request->filter_bulan_xls));
            $p = TransaksiProduk::with('user')->whereMonth('tanggal_transaksi_produk',$b)->whereYear('tanggal_transaksi_produk',$t)->get();   
        }else if ($request->filter_range1_xls != null && $request->filter_range2_xls != null) {
            $m = date('Y-m-d', strtotime($request->filter_range1_xls));
            $s = date('Y-m-d', strtotime($request->filter_range2_xls));
            $p = TransaksiProduk::with('user')->whereBetween('tanggal_transaksi_produk',[$m, $s])->get();    
        }else{
            $p = TransaksiProduk::with('user')->get();
        }

        if (empty($p)) {
            return redirect()->back()->withErrors('Export gagal');
        }

        $data = self::beautifyDataTransaksiPenjualan($p);
        $KOLOM = [
            'NO', 'Kode Transaksi', 'Kode Produk',
            'Nama Produk','Jumlah Penjualan', 'Tanggal Transaksi', 'Total Penjualan Produk',
            'Nama Kasir',
        ];
        array_unshift($data, $KOLOM);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Team 7 | Zoepy Petshop")
            ->setLastModifiedBy(auth()->user()->nama_lengkap)
            ->setTitle("Data Transaksi Produk")
            ->setSubject("Data Transaksi Produk")
            ->setDescription("Data Transaksi Produk");
        $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $data,
                'A1'
            );
        for ($i = 'A'; $i !=  'I'; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    public function exportTransaksiJasa(Request $request)
    {
        $role = auth()->user()->role;
        if(!isset($role) && $role == 0){
            return redirect()->back()->withErrors('Export gagal');
        }
        $filename = 'Data Transaksi Jasa.xlsx';
        
        if ($request->filter_bulan_xls) {
            $b = date('m', strtotime($request->filter_bulan_xls));
            $t = date('Y', strtotime($request->filter_bulan_xls));
            $p = TransaksiJasa::with('user')->whereMonth('tanggal_transaksi_jasa',$b)->whereYear('tanggal_transaksi_jasa',$t)->get();   
        }else if ($request->filter_range1_xls != null && $request->filter_range2_xls != null) {
            $m = date('Y-m-d', strtotime($request->filter_range1_xls));
            $s = date('Y-m-d', strtotime($request->filter_range2_xls));
            $p = TransaksiJasa::with('user')->whereBetween('tanggal_transaksi_jasa',[$m, $s])->get();    
        }else{
            $p = TransaksiJasa::with('user')->get();
        }

        if (empty($p)) {
            return redirect()->back()->withErrors('Export gagal');
        }

        $data = self::beautifyDataTransaksiJasa($p);
        $KOLOM = [
            'NO', 'Kode Transaksi', 'Nama Jasa','Tanggal Transaksi', 'Total Transaksi Jasa',
            'Nama Kasir',
        ];
        array_unshift($data, $KOLOM);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Team 7 | Zoepy Petshop")
            ->setLastModifiedBy(auth()->user()->nama_lengkap)
            ->setTitle("Data Transaksi Jasa")
            ->setSubject("Data Transaksi Jasa")
            ->setDescription("Data Transaksi Jasa");
        $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $data,
                'A1'
            );
        for ($i = 'A'; $i !=  'G'; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    public function exportCustomer()
    {
        $role = auth()->user()->role;
        if(!isset($role) && $role == 0){
            return redirect()->back()->withErrors(['msg' => 'export gagal']);
        }
        $filename = 'Data Customer.xlsx';
        
        $p = DB::select('CALL getCustomer()');

        $data = self::beautifyDataCustomer($p);
        
        $KOLOM = [
            'NO', 'Nama Lengkap', 'Nomor HP','Email', 'Jenis Kelamin',
            'Nama Hewan','Umur Hewan', 'Tipe Hewan', 'Detail Alamat','Provinsi','Kabupaten','Kecamatan','Kelurahan',
        ];
        array_unshift($data, $KOLOM);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Team 7 | Zoepy Petshop")
            ->setLastModifiedBy(auth()->user()->nama_lengkap)
            ->setTitle("Data Customer")
            ->setSubject("Data Customer")
            ->setDescription("Data Keseluruhan Customer");
        $spreadsheet->getActiveSheet()
            ->fromArray(
                $data,
                'A1'
            );
        for ($i = 'A'; $i !=  'N'; $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }
        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');
        $response->headers->set('Cache-Control', 'max-age=0');
        return $response;
    }

    private static function beautifyDataTransaksiPenjualan($data)
    {
        $out = [];
        $cout = 1;
        foreach ($data as $i => $d) {
            array_push($out, [
                $cout, $d->kode_transaksi, $d->produk->kode_produk,
                $d->produk->nama_produk, $d->jumlah_barang, 
                date('d-M-Y', strtotime($d->tanggal_transaksi_produk)),
                $d->total_harga_produk,$d->user->nama_lengkap
            ]);
            $cout++;
        }
        return $out;
    }

    private static function beautifyDataTransaksiJasa($data)
    {
        $out = [];
        $cout = 1;
        foreach ($data as $i => $d) {
            array_push($out, [
                $cout, $d->kode_transaksi_jasa, $d->jasa->nama_jasa, date('d-M-Y', strtotime($d->tanggal_transaksi_jasa)),
                $d->total_harga_jasa,$d->user->nama_lengkap
            ]);
            $cout++;
        }
        return $out;
    }

    private static function beautifyDataCustomer($data)
    {
        $out = [];
        $inc = 1;
        foreach ($data as $i => $d) {
            array_push($out, [
                $inc, $d->nama_lengkap, $d->no_telepon,$d->email,$d->gender,
                $d->nama_hewan, $d->umur_hewan, $d->tipe_hewan,$d->detail_alamat,
                $d->provinsi,$d->kabupaten,$d->kecamatan, $d->kelurahan,
            ]);
            $inc++;
        }
        return $out;
    }

    private static function beautifyDataProduk($data)
    {
        $out = [];
        foreach ($data as $i => $d) {
            array_push($out, [
                $d->id, $d->kode_produk, $d->nama_produk,
                $d->bobot, $d->harga, $d->stok,$d->gambar_produk,
            ]);
        }
        return $out;
    }

    private static function isset($data){
        if(isset($data)){
            return $data;
        }else{
            return "-";
        }
    }
}
