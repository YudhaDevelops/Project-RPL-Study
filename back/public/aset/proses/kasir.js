const MY_URL = "http://127.0.0.1:8000"
// // import $ from "jquery";
// const MY_URL = "https://if20.skom.id/back/public";

$("[name=id_hewan]").on("change", (e) => {
  let selectedHewan = e.target.value;
  let namaUser = $("[name=nama_lengkap]");
  getUser(selectedHewan, namaUser);
});

const getUser = (id_hewan, el) => {
  $.get(`${MY_URL}/kasir/getUser/${id_hewan}`, (data, status) => {
    $('#nama_customer').val(data.data);
  })
}

$("[name=jenis_grooming]").on("change", (e) => {
  let id_jasa = e.target.value
  getJasa(id_jasa)
})

const getJasa = (id_jasa) => {
  $.get(`${MY_URL}/kasir/getJasa/${id_jasa}`, (data, status) => {
    $('#harga').val(data.data.harga_jasa)
    $('#harga_grooming').val("Rp." + data.data.harga_jasa)
  })
}

// dropdown select produk
$("[name=pilih_produk]").on('change', (e) => {
  let selectProduk = e.target.value
  tambahKeranjang(selectProduk)
})

const tambahKeranjang = (kodeProduk) => {
  $.get(`${MY_URL}/kasir/tambah_keranjang/${kodeProduk}`, (res, status) => {
    if (status == "success") {
      window.location.reload();
    }
  })
}

// input proses bayar
$('body').on('keyup', '#user_membayar', function (e) {
  e.preventDefault()

  let total_bayar = $('#total_bayar_cs').val()
  let user_membayar = e.target.value
  let hasil = user_membayar - total_bayar;

  if (hasil < 0) {
    hasil = 0;
    $('#btn_bayar').attr('disabled', 'disabled');
    var hasilString = "Rp." + hasil;
  } else if (hasil == 0) {
    hasil = 0
    $('#btn_bayar').removeAttr("disabled");
    var hasilString = 'Uang Pas';
  } else {
    hasil = hasil;
    $('#btn_bayar').removeAttr("disabled");
    var hasilString = hasil;
  }


  $('#kembalian').val(hasilString)
  $('#kembalian2').val(hasil)
})

// $("input[name='stok']").TouchSpin();
$("input[name='stok']").TouchSpin({
  min: 0,
  max: 2000,
  step: 1,
});

$("input[name='jumlah_barang']").TouchSpin({
  min: 0,
  max: 2000,
  verticalbuttons: true,
  // verticalupclass: 'fa fa-plus',
  // verticaldownclass: 'fa fa-minus'
});

$('body').on('click', '#hapus_anjing', function (e) {
  e.preventDefault();

  var link = $(this).attr('href');

  Swal.fire({
    title: 'Apakah Anda Yakin?',
    text: "Untuk Menghapus Data Produk Ini , Data Pada Table Lain Akan Ikut Terhapus, Lakukan Backup Terlebih Dahulu Untuk Menghapus Produk Ini.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = link;
    } else if (result.dismiss) {
      Swal.fire(
        'Canceled!',
        'Data tidak jadi dihapus'
      )
    }
  })
})

$('body').on('click', '#hapus_data_keranjang', function (e) {
  e.preventDefault();

  var link = $(this).attr('href');

  Swal.fire({
    title: 'Apakah Anda Yakin?',
    text: "Untuk Menghapus Data Produk Ini?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = link;
    } else if (result.dismiss) {
      Swal.fire(
        'Canceled!',
        'Data tidak jadi dihapus'
      )
    }
  })
})

$('body').on('click', '#tambah_jumlah_barang', function () {
  let kode_produk = $(this).data('id');
  updateKeranjangTambah(kode_produk)
})

const updateKeranjangTambah = (id) => {
  $.get(`${MY_URL}/kasir/updateKeranjangJsTambah/${id}`, (data, status) => {
    location.reload();
    if (data.success == 200) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'success',
        title: `${data.message}`,
      })
    } else {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'error',
        title: `${data.message}`,
      })
    }
  })
}


$('body').on('click', '#kurang_jumlah_barang', function () {
  let kode_produk = $(this).data('id');
  // alert(kode_produk)
  updateKeranjangKurang(kode_produk)
})

const updateKeranjangKurang = (id) => {
  $.get(`${MY_URL}/kasir/updateKeranjangJsKurang/${id}`, (data, status) => {
    // console.log(data);
    location.reload();
    if (data.success == 200) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'success',
        title: `${data.message}`,
      })
    } else {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: 'error',
        title: `${data.message}`,
      })
    }
  })
}
