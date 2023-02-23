<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('landing');
});

// bagian landing
Route::group(['controller' => WebController::class], function () {
    // landing
    Route::get('/', 'landing')->name('landing');
    Route::get('/semua-produk', 'getProduk')->name('produk');
    Route::get('/chartMingguan','chartMingguan');
    Route::get('/getHariChartMingguan','getHariChartMingguan');
});


Route::group([
    'controller' => AuthController::class,
], function () {
    Route::get('/login', 'index')->name('login');
    Route::get('/register', 'register')->name('home.register');

    Route::post('/formLogin', 'login')->name('user.login');
    Route::post('/formRegister', 'formRegister')->name('user.register');

    // forget password
    Route::get('/forget-password', 'forgetPassword')->name('user.forget-password');
    Route::post('/send-email', 'sendEmail')->name('user.send-email');

    Route::get('/reset-password/{token}', 'resetPassword')->name('user.reset-password/{token}');
    Route::post('/update-password', 'updatePassword')->name('user.update-password');
});

Route::group(['middleware' => ['auth']], function () {

    // akses kasir
    Route::group([
        'middleware' => ['cekUserLogin:1'],
        'prefix'     => 'kasir',
        'controller' => KasirController::class,
    ], function () {
        // kasir dashboard
        Route::get('/', function () {
            return redirect()->route('kasir.index');
        });
        Route::get('/jual-produk', 'jualProduk')->name('kasir.jual-produk');
        Route::get('/tambah_keranjang/{id}', 'tambahKeranjang')->name('kasir.tambah_keranjang');
        Route::put('/updateKeranjang/{kode_produk}', 'updateKeranjang')->name('update.updateKeranjang');
        Route::get('/delete_keranjang/{id}', 'deleteKeranjang')->name('delete.delete_keranjang');
        Route::get('/reset_keranjang', 'resetKeranjang')->name('delete.reset_keranjang');

        Route::post('/transaksi-produk', 'transaksiProduk')->name('kasir.transaksi-produk');
        Route::get('/getProduk/{id}', 'getProduk')->name('getProduk');

        Route::get('/dashboard', 'dashboard')->name('kasir.index');
        Route::get('/customer', 'customer')->name('kasir.customer');
        Route::get('/customer/delete/{id}', 'deleteCustomer')->name('delete.customer');
        Route::post('/customer/create', 'create_customer')->name('kasir.add.customer');
        Route::put('/customer/update/{id}', 'update_customer')->name('kasir.update.customer');

        Route::get('/getKabupaten/{id}', 'getKabupaten')->name('kasir.getKabupaten');
        Route::get('/getKecamatan/{id}', 'getKecamatan')->name('kasir.getKecamatan');
        Route::get('/getKelurahan/{id}', 'getKelurahan')->name('kasir.getKelurahan');

        Route::get('/profile', 'settingProfile')->name('kasir.settingProfile');
        Route::put('/update-profile/{id}', 'updateProfile')->name('kasir.update-profile');
        Route::put('/update-password/{id}', 'updatePassword')->name('kasir.update-password');
        Route::post('/upload-foto-profile', 'uploadFotoProfile')->name('kasir.upload-foto-profile');

        Route::get('/updateKeranjangJsTambah/{kode_produk}', 'updateKeranjangJSTambah');
        Route::get('/updateKeranjangJsKurang/{kode_produk}', 'updateKeranjangJSKurang');

        Route::post('/saveImageHewan', 'saveImageHewan')->name('costomer.saveImageHewan');
    });

    Route::group([
        'controller' => HewanController::class,
        'prefix'     => 'kasir',
    ], function () {
        Route::post('/create-hewan', 'addHewan')->name('hewan.create-hewan');
        Route::get('/delete-hewan/{id}', 'deleteHewan')->name('delete.delete-hewan');
        Route::put('/update-hewan/{id}', 'updateHewan')->name('update.update-hewan');
    });

    Route::group([
        'middleware' => ['cekUserLogin:1'],
        'prefix'     => 'kasir',
        'controller' => ProdukController::class,
    ], function () {
        // produk makanan anjing
        Route::get('/anjing', 'produkAnjing')->name('produk.anjing');
        Route::post('/anjing', 'simpanProdukAnjing')->name('anjing.simpan');
        Route::put('/anjing/{id}', 'updateProdukAnjing')->name('anjing.update');
        Route::get('/anjing/show/{id}', 'tampilProdukAnjing')->name('anjing.show');
        Route::get('/anjing/delete/{id}', 'deleteProdukAnjing')->name('anjing.delete');

        // produk makanan kucing
        Route::get('/kucing', 'produkKucing')->name('produk.kucing');
        Route::post('/kucing', 'simpanProdukKucing')->name('kucing.simpan');
        Route::put('/kucing/{id}', 'updateProdukKucing')->name('kucing.update');
        Route::get('/kucing/show/{id}', 'tampilProdukKucing')->name('kucing.show');
        Route::get('/kucing/delete/{id}', 'deleteProdukKucing')->name('kucing.delete');
    });

    Route::group([
        'controller' => JasaController::class,
        'prefix'     => 'kasir',
    ], function () {
        Route::get('/transaksi-jasa', 'transaksiJasa')->name('jasa.transaksi-jasa');
        Route::post('/pembayaran-jasa', 'pembayaranJasa')->name('jasa.pembayaran-jasa');

        Route::get('/penitipan', 'penitipan')->name('jasa.penitipan');
        Route::post('/penitipan', 'savePenitipan')->name('jasa.save.penitipan');
        Route::put('/penitipan/{id}', 'updatePenitipan')->name('penitipan.update');
        Route::get('/penitipan/delete/{id}', 'deletePenitipan')->name('penitipan.delete');
        Route::get('/penitipan-selesai/{id}/{durasi}', 'penitipanSelesai')->name('penitipan.selesai');
        Route::get('/getUser/{id}', 'getUser')->name('jasa.update.Penitipan');

        Route::get('/grooming_penitipan', 'grooming_penitipan')->name('jasa.grooming.penitipan');
        Route::post('/grooming_penitipan','saveGroomingPenitipan')->name('jasa.saveGroomingPenitipan');

        Route::get('/grooming', 'grooming')->name('jasa.grooming');
        Route::post('/grooming', 'saveGrooming')->name('jasa.save.grooming');
        Route::put('/grooming/{id}', 'updateGrooming')->name('jasa.update.grooming');
        Route::get('/grooming-delete/{id}', 'groomingDelete')->name('delete.grooming-delete');
        Route::get('/grooming-selesai/{id}', 'groomingSelesai')->name('jasa.grooming-selesai');
        Route::post('/grooming-transaksi', 'groomingTransaksi')->name('transaksi.grooming-transaksi');

        Route::get('/getJasa/{id}', 'getJasa')->name('getJasa');
        Route::get('/getDetailBayar/{id}', 'getDetailBayar')->name('getDetailBayar');
    });

    // akses owner
    Route::group([
        'middleware' => ['cekUserLogin:2'],
        'prefix'     => 'owner',
        'controller' => OwnerController::class,
    ], function () {
        // owner dashboard sementara
        Route::get('/', function () {
            return redirect()->route('owner.index');
        });
        Route::get('/dashboard', 'dashboard')->name('owner.index');

        Route::get('/account-kasir', 'accountKasir')->name('owner.account-kasir');
        Route::post('/add-account-kasir', 'addAccountKasir')->name('owner.add-account-kasir');
        Route::put('/update-account-kasir/{id}', 'updateAccountKasir')->name('update.update-account-kasir');
        Route::get('/delete-account-kasir/{id}', 'deleteAccountKasir')->name('delete.delete-account-kasir');

        Route::get('/laporan-penjualan', 'laporanPenjualan')->name('owner.laporan-penjualan');
        Route::get('/laporan-penjualan/delete/{id}', 'deleteLaporanPenjualan')->name('delete.laporan-penjualan');

        Route::get('/laporan-jasa', 'laporanJasa')->name('owner.laporan-jasa');
        Route::get('/laporan-jasa/delete/{id}', 'deletelaporanJasa')->name('delete.laporan-jasa');

        Route::get('/filter-laporan', 'filterLaporan')->name('owner.filter-laporan');

        Route::get('/profile', 'settingProfile')->name('owner.settingProfile');
        Route::put('/update-profile/{id}', 'updateProfile')->name('owner.update-profile');
        Route::put('/update-password/{id}', 'updatePassword')->name('owner.update-password');

        Route::get('/setting-jasa', 'settingJasa')->name('owner.setting-jasa');
        Route::put('/update-jasa/{id}', 'updateJasa')->name('owner.update-jasa');
        Route::post('/update-foto-jasa', 'updateFotoJasa')->name('update-foto-jasa');

        Route::post('/upload-foto-profile', 'uploadFotoProfile')->name('kasir.upload-foto-profile');
    });

    Route::group([
        'middleware' => ['cekUserLogin:0'],
        'controller' => CustomerController::class,
        'prefix'     => 'guest',
    ], function () {
        Route::get('/index', 'index')->name('guest.index');
        Route::get('/infoPet', 'infoPet')->name('guest.infoPet');
        Route::get('/ganti-password', 'gantiPassword')->name('guest.ganti-password');
        Route::post('/ganti-password', 'customerGantiPassword')->name('send.ganti-password');
        Route::get('/infoPet/detail-groming/{id_grooming}/{id_hewan}', 'infoPetDetailGroming')->name('guest.infoPet.detail.grooming');
        Route::get('/infoPet/detail-penitipan/{id_penitipan}/{id_hewan}', 'infoPetDetailPenitipan')->name('guest.infoPet.detail.penitipan');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');
});


Route::group(['controller' => AlamatController::class,], function () {
    // kasir dashboard
    Route::get('/getKabupaten/{id}', 'getKabupaten')->name('alamat.getKabupaten');
    Route::get('/getKecamatan/{id}', 'getKecamatan')->name('alamat.getKecamatan');
    Route::get('/getKelurahan/{id}', 'getKelurahan')->name('alamat.getKelurahan');
});

Route::group(['controller' => PDFController::class,], function () {
    Route::post('/print_nota', 'printNotaPembayaranProduk')->name('pdf.print_nota');
    Route::post('/print_grooming', 'printNotaPembayaranJasa')->name('pdf.print_grooming');
    Route::get('/exportPDFProdukAnjing', 'exportPDFProdukAnjing')->name('exportPDFProdukAnjing');
    Route::get('/exportPDFProdukKucing', 'exportPDFProdukKucing')->name('exportPDFProdukKucing');
    Route::get('/exportPDFCustomer', 'exportPDFCustomer')->name('exportPDFCustomer');

    Route::get('/exportPDFTransaksiProduk', 'exportPDFTransaksiProduk')->name('exportPDFTransaksiProduk');
    Route::get('/exportPDFTransaksiJasa', 'exportPDFTransaksiJasa')->name('exportPDFTransaksiJasa');
});

Route::group([
    'controller' => ExcelController::class,
], function () {
    Route::get('/exportProdukAnjing', 'exportProdukAnjing')->name('exportProdukAnjing');
    Route::get('/exportProdukKucing', 'exportProdukKucing')->name('exportProdukKucing');
    Route::get('/exportProdukSemua', 'exportProdukSemua')->name('exportProdukSemua');

    Route::get('/exportTransaksiProduk', 'exportTransaksiProduk')->name('exportTransaksiProduk');
    Route::get('/exportTransaksiJasa', 'exportTransaksiJasa')->name('exportTransaksiJasa');

    Route::get('/exportCustomer', 'exportCustomer')->name('exportCustomer');
});
