<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "DROP PROCEDURE IF EXISTS `getCustomer`;
            CREATE PROCEDURE `getCustomer` ()
            BEGIN
            SELECT users.id 'id_user', users.nama_lengkap, hewan.gambar_hewan, users.gender, users.email, users.no_telepon, hewan.id_hewan 'id_hewan', users.id_alamat, alamat.detail_alamat, alamat.provinsi,alamat.kabupaten,alamat.kecamatan,alamat.kelurahan,hewan.nama_hewan,hewan.tipe_hewan,hewan.umur_hewan 
            FROM users JOIN alamat ON users.id_alamat = alamat.id 
            JOIN hewan ON users.id = hewan.id_user
            WHERE users.role = 0;
            END;";

        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getKasir`;
            CREATE PROCEDURE `getKasir` ()
            BEGIN
            SELECT users.id, users.nama_lengkap, users.gender, users.email, users.no_telepon, users.id_alamat, alamat.detail_alamat, alamat.provinsi,alamat.kabupaten,alamat.kecamatan,alamat.kelurahan
            FROM users JOIN alamat ON users.id_alamat = alamat.id 
            WHERE users.role = 1;
            END;";

        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getHewan`;
            CREATE PROCEDURE `GetHewan` ()
            BEGIN
            SELECT *  FROM hewan;
            END;";

        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `GetProducts`;
            CREATE PROCEDURE `GetProducts` ()
            BEGIN
            SELECT *  FROM produk;
            END;";

        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getProfile`;
            CREATE PROCEDURE `getProfile` (IN idx int)
            BEGIN
            SELECT users.id,users.nama_lengkap, users.foto_profile, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, alamat.detail_alamat, alamat.provinsi, alamat.kabupaten,alamat.kecamatan, alamat.kelurahan 
            FROM users JOIN alamat ON alamat.id = users.id_alamat
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `cekPenggunaanJasa`;
            CREATE PROCEDURE `cekPenggunaanJasa` (IN idx int)
            BEGIN
            SELECT users.id 'id_user',users.nama_lengkap 'pemilik', grooming.id 'id_grooming'
            FROM users JOIN hewan ON users.id = hewan.id_user
            JOIN grooming ON hewan.id_hewan = grooming.id_hewan
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getGroomingByUser`;
            CREATE PROCEDURE `getGroomingByUser` (IN idx int)
            BEGIN
            SELECT hewan.id_hewan,hewan.nama_hewan,jasa.nama_jasa, jasa.gambar_jasa, grooming.id 'id_grooming',grooming.tanggal_grooming 'tanggal_grooming'
            FROM hewan JOIN users ON hewan.id_user = users.id
            LEFT JOIN grooming ON hewan.id_hewan = grooming.id_hewan
            JOIN jasa ON jasa.id = grooming.id_jasa
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getPenitipanByUser`;
            CREATE PROCEDURE `getPenitipanByUser` (IN idx int)
            BEGIN
            SELECT hewan.id_hewan,hewan.nama_hewan,jasa.nama_jasa, jasa.gambar_jasa,penitipan.id 'id_penitipan', penitipan.tanggal_masuk, penitipan.tanggal_keluar
            FROM hewan JOIN users ON hewan.id_user = users.id
            LEFT JOIN penitipan ON hewan.id_hewan = penitipan.id_hewan 
            JOIN jasa ON jasa.id = penitipan.id_jasa
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);


        $procedure = "DROP PROCEDURE IF EXISTS `getGroomingAll`;
            CREATE PROCEDURE `getGroomingAll` ()
            BEGIN
            SELECT grooming.id 'id_grooming',hewan.tipe_hewan, grooming.id_hewan 'id_hewan', hewan.nama_hewan, jasa.nama_jasa, jasa.harga_jasa, jasa.id 'id_jasa', users.nama_lengkap, grooming.tahapan, grooming.tanggal_grooming, grooming.waktu_masuk, grooming.waktu_keluar
            FROM grooming JOIN jasa ON grooming.id_jasa = jasa.id
            LEFT JOIN hewan ON hewan.id_hewan = grooming.id_hewan
            JOIN users ON hewan.id_user = users.id WHERE grooming.tahapan NOT IN ('Selesai');
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getTagihanPembayaran`;
            CREATE PROCEDURE `getTagihanPembayaran` ()
            BEGIN
            SELECT DISTINCT users.id 'pemilik'
            FROM pembayaran_jasa 
            JOIN hewan ON hewan.id_hewan = pembayaran_jasa.id_hewan
            JOIN users ON users.id = hewan.id_user;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getDetailBayar`;
            CREATE PROCEDURE `getDetailBayar` (IN idx int)
            BEGIN
            SELECT users.nama_lengkap, hewan.nama_hewan,hewan.id_hewan,jasa.id 'id_jasa', jasa.nama_jasa, jasa.harga_jasa, pembayaran_jasa.durasi
            FROM pembayaran_jasa JOIN hewan ON hewan.id_hewan = pembayaran_jasa.id_hewan
            JOIN users ON users.id = hewan.id_user
            JOIN jasa ON jasa.id = pembayaran_jasa.id_jasa
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getUserHewan`;
            CREATE PROCEDURE `getUserHewan` (IN idx int)
            BEGIN
            SELECT users.id 'id_user',users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, hewan.id_hewan 'id_hewan', hewan.nama_hewan, hewan.tipe_hewan, hewan.umur_hewan, hewan.gambar_hewan 
            FROM users JOIN hewan ON users.id = hewan.id_user
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getUserHewanAll`;
            CREATE PROCEDURE `getUserHewanAll` ()
            BEGIN
            SELECT users.id 'id_user',users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, hewan.id_hewan 'id_hewan', hewan.nama_hewan, hewan.tipe_hewan, hewan.umur_hewan, hewan.gambar_hewan 
            FROM users JOIN hewan ON users.id = hewan.id_user
            WHERE users.role = 0;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getUserHewanAlamat`;
            CREATE PROCEDURE `getUserHewanAlamat` (IN idx int)
            BEGIN
            SELECT users.id,users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, hewan.id_hewan, hewan.nama_hewan, hewan.tipe_hewan, hewan.umur_hewan, hewan.gambar_hewan, alamat.detail_alamat, alamat.provinsi, alamat.kabupaten,alamat.kecamatan, alamat.kelurahan 
            FROM users JOIN hewan ON hewan.id_user = users.id
            JOIN alamat ON users.id_alamat = alamat.id
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getDetailInfoGrooming`;
            CREATE PROCEDURE `getDetailInfoGrooming`(IN `grooming_id` INT, IN `hewan_id` VARCHAR(255) CHARSET utf8)
            BEGIN
            SELECT jasa.nama_jasa, jasa.harga_jasa, hewan.nama_hewan, hewan.tipe_hewan, hewan.gambar_hewan, users.nama_lengkap 'pemilik',grooming.id, grooming.tahapan,grooming.tanggal_grooming,grooming.waktu_masuk,grooming.waktu_keluar FROM grooming JOIN jasa ON jasa.id = grooming.id_jasa JOIN hewan ON hewan.id_hewan = grooming.id_hewan JOIN users ON users.id = hewan.id_user WHERE grooming.id = grooming_id AND grooming.id_hewan = hewan_id;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getDetailInfoPenitipan`;
            CREATE PROCEDURE `getDetailInfoPenitipan`(IN `penitipan_id` INT, IN `hewan_id` VARCHAR(255) CHARSET utf8)
            BEGIN
            SELECT jasa.nama_jasa, jasa.harga_jasa, hewan.nama_hewan, hewan.tipe_hewan, hewan.gambar_hewan, users.nama_lengkap 'pemilik',penitipan.id, penitipan.no_kandang, penitipan.tanggal_masuk, penitipan.tanggal_keluar
            FROM penitipan JOIN jasa ON jasa.id = penitipan.id_jasa 
            JOIN hewan ON hewan.id_hewan = penitipan.id_hewan JOIN users ON users.id = hewan.id_user 
            WHERE penitipan.id = penitipan_id AND penitipan.id_hewan = hewan_id;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getUserHewanPenitipanJasaAlamat`;
            CREATE PROCEDURE `getUserHewanPenitipanJasaAlamat` (IN idx int)
            BEGIN
            SELECT users.id,users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, hewan.id_hewan, hewan.nama_hewan, hewan.tipe_hewan, hewan.umur_hewan, hewan.gambar_hewan, penitipan.id_hewan, penitipan.id_jasa, penitipan.no_kandang, penitipan.tanggal_masuk, penitipan.tanggal_keluar, jasa.id_jasa, jasa.nama_jasa, jasa.harga_jasa, jasa.gambar_jasa, alamat.detail_alamat, alamat.provinsi, alamat.kabupaten,alamat.kecamatan, alamat.kelurahan 
            FROM users JOIN hewan ON users.id_alamat = hewan.id_hewan 
			JOIN penitipan ON users.id_alamat = penitipan.id
            JOIN jasa ON users.id_alamat = jasa.id_jasa
			JOIN alamat ON users.id_alamat = alamat.id 
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getPenitipanAll`;
            CREATE PROCEDURE `getPenitipanAll` ()
            BEGIN
            SELECT users.id,users.nama_lengkap, hewan.nama_hewan, penitipan.id 'id_penitipan', penitipan.no_kandang, penitipan.tanggal_masuk, penitipan.tanggal_keluar, jasa.harga_jasa
            FROM users JOIN hewan ON users.id = hewan.id_user 
            JOIN penitipan ON hewan.id_hewan = penitipan.id_hewan
            JOIN jasa ON penitipan.id_jasa = jasa.id
            WHERE penitipan.is_selesai = 0;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getUserHewanGroomingJasaAlamat`;
            CREATE PROCEDURE `getUserHewanGroomingJasaAlamat` (IN idx int)
            BEGIN
            SELECT users.id,users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, hewan.id_hewan, hewan.nama_hewan, hewan.tipe_hewan, hewan.umur_hewan, hewan.gambar_hewan, grooming.id, jasa.id_jasa, jasa.nama_jasa, jasa.harga_jasa, jasa.gambar_jasa, alamat.detail_alamat, alamat.provinsi, alamat.kabupaten,alamat.kecamatan, alamat.kelurahan 
            FROM users JOIN hewan ON users.id_alamat = hewan.id_hewan 
			JOIN grooming ON users.id_alamat = grooming.id
            JOIN jasa ON users.id_alamat = jasa.id_jasa
			JOIN alamat ON users.id_alamat = alamat.id 
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getTransaksijasaUserPenitipanGroomingJasa`;
            CREATE PROCEDURE `getTransaksijasaUserPenitipanGroomingJasa` (IN idx int)
            BEGIN
            SELECT transaksi_jasa.id_transaksi_jasa, transaksi_jasa.tanggal_transaksi_jasa, transaksi_jasa.total_harga_jasa, users.id,users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, penitipan.id_hewan, penitipan.id_jasa, penitipan.no_kandang, penitipan.tanggal_masuk, penitipan.tanggal_keluar, grooming.id, jasa.id_jasa, jasa.nama_jasa, jasa.harga_jasa, jasa.gambar_jasa
            FROM transaksi_jasa JOIN users ON transaksi_jasa.id_transaksi_jasa = users.id_alamat
			JOIN penitipan ON transaksi_jasa.id_transaksi_jasa = penitipan.id
            JOIN grooming ON transaksi_jasa.id_transaksi_jasa = grooming.id
			JOIN jasa ON transaksi_jasa.id_transaksi_jasa = jasa.id_jasa
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getTransaksiproduksUserProduk`;
            CREATE PROCEDURE `getTransaksiproduksUserProduk` (IN idx int)
            BEGIN
            SELECT transaksi_produks.id_transaksi_produk, transaksi_produks.tanggal_transaksi_produk, transaksi_produks.total_harga_produk, users.id,users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, produk.id_produk, produk.nama_produk, produk.bobot, produk.harga, produk.stok, produk.gambar_produk
            FROM transaksi_produks JOIN users ON transaksi_produks.id_transaksi_produk = users.id_alamat
			JOIN produk ON produk.id_produk = users.id_alamat
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getOlahdataproduksUserProduk`;
            CREATE PROCEDURE `getOlahdataproduksUserProduk` (IN idx int)
            BEGIN
            SELECT olah_data_produks.id_olah_data_produk, olah_data_produks.tanggal_edit, users.id,users.nama_lengkap, users.email, users.gender,users.role, users.no_telepon,users.id_alamat, produk.id_produk, produk.nama_produk, produk.bobot, produk.harga, produk.stok, produk.gambar_produk
            FROM olah_data_produks JOIN users ON olah_data_produks.id_olah_data_produk = users.id_alamat
			JOIN produk ON produk.id_produk = users.id_alamat
            WHERE users.id = idx;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `resetKeranjang`;
            CREATE PROCEDURE `resetKeranjang` ()
            BEGIN
            DELETE FROM detail_transaksi_produk;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `getLaporan`;
            CREATE PROCEDURE `getLaporan` ()
            BEGIN
            SELECT transaksi_produk.id, transaksi_produk.kode_transaksi, users.nama_lengkap 'nama_kasir', produk.kode_produk, produk.nama_produk, transaksi_produk.jumlah_barang, transaksi_produk.tanggal_transaksi_produk 'tanggal_transaksi', transaksi_produk.total_harga_produk 
            FROM users JOIN transaksi_produk ON transaksi_produk.user_id = users.id 
            JOIN produk ON transaksi_produk.produk_id = produk.id WHERE users.role = 1;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `OrderByAsc`;
            CREATE PROCEDURE `OrderByAsc` ()
            BEGIN
            SELECT * FROM produk
            ORDER BY produk.nama_produk ASC;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `OrderByDesc`;
            CREATE PROCEDURE `OrderByDesc` ()
            BEGIN
            SELECT * FROM produk
            ORDER BY produk.nama_produk DESC;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `HargaRendahTinggi`;
            CREATE PROCEDURE `HargaRendahTinggi` ()
            BEGIN
            SELECT * FROM produk
            ORDER BY produk.harga ASC;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `HargaTinggiRendah`;
            CREATE PROCEDURE `HargaTinggiRendah` ()
            BEGIN
            SELECT * FROM produk
            ORDER BY produk.harga DESC;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `ProdukTerbaru`;
            CREATE PROCEDURE `ProdukTerbaru` ()
            BEGIN
            SELECT * FROM produk WHERE created_at BETWEEN '2022-11-01' AND '2022-12-02';
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `ProdukTerlaris`;
            CREATE PROCEDURE `ProdukTerlaris` ()
            BEGIN
            SELECT produk.id, produk.nama_produk, SUM(jumlah_barang) total_produk_terlaris 
            FROM transaksi_produk JOIN produk ON transaksi_produk.produk_id = produk.id GROUP BY transaksi_produk.produk_id ORDER BY total_produk_terlaris DESC LIMIT 6;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `LarisAnjing`;
            CREATE PROCEDURE `LarisAnjing` ()
            BEGIN
            SELECT transaksi_produk.produk_id 'id_produk', produk.nama_produk, SUM(jumlah_barang) total_produk_terlaris 
            FROM transaksi_produk JOIN produk ON transaksi_produk.produk_id = produk.id 
            WHERE produk.kode_produk LIKE '%PA%'
            GROUP BY id_produk 
            ORDER BY total_produk_terlaris
            DESC LIMIT 3;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `LarisKucing`;
            CREATE PROCEDURE `LarisKucing` ()
            BEGIN
            SELECT transaksi_produk.produk_id 'id_produk', produk.nama_produk, SUM(jumlah_barang) total_produk_terlaris 
            FROM transaksi_produk JOIN produk ON  transaksi_produk.produk_id = produk.id 
            WHERE produk.kode_produk LIKE '%PK%'
            GROUP BY transaksi_produk.produk_id 
            ORDER BY total_produk_terlaris
            DESC LIMIT 3;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `LarisNoKey`;
            CREATE PROCEDURE `LarisNoKey` ()
            BEGIN
            SELECT transaksi_produk.produk_id 'id_produk', produk.nama_produk, SUM(jumlah_barang) total_produk_terlaris 
            FROM transaksi_produk JOIN produk ON transaksi_produk.produk_id = produk.id 
            GROUP BY id_produk 
            ORDER BY total_produk_terlaris
            DESC;
            END;";
        DB::unprepared($procedure);

        $procedure = "DROP PROCEDURE IF EXISTS `LarisWithKey`;
            CREATE PROCEDURE `LarisWithKey`(IN `nama_produk` VARCHAR(255) CHARSET utf8)
            BEGIN
            SELECT transaksi_produk.produk_id 'id_produk', produk.nama_produk, SUM(jumlah_barang) total_produk_terlaris 
            FROM transaksi_produk JOIN produk ON transaksi_produk.produk_id = produk.id 
            WHERE lower(produk.nama_produk)COLLATE utf8mb4_general_ci LIKE CONCAT('%', lower(nama_produk) , '%')
            GROUP BY id_produk 
            ORDER BY total_produk_terlaris
            DESC;
            END;";
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
