@extends('layouts.master', ['transaksi_jasa' => 'active', 'title' => 'Tagihan Transaksi Jasa | '])
@section('head')
@stop

@section('jsFooter')
    <script>
        // const MY_URL = "https://if20.skom.id/back/public";
        const MY_URL = "http://127.0.0.1:8000"


        $('body').on('click', '#proses_bayar_jasa', function() {
            let pemilik = $(this).data('id');
            $("#table-bayar tr").remove();
            $('#pemilik_judul h4').remove()
            $('#user_membayar').val("")
            $('#total_bayar_cs').val("")
            $('#total_bayar_lihat').val("")
            $('#kembalian').val("")
            $('#kembalian2').val("")
            detailBayar(pemilik);
            $('#bayar_grooming_modal').modal('show');
        })

        $('body').on('keyup', '#user_membayar_jasa', function(e) {
            e.preventDefault()

            let total_bayar = $('#total_bayar_cs').val()
            let user_membayar = e.target.value
            let hasil = user_membayar - total_bayar;

            if (hasil < 0) {
                hasil = 0
                $('#btn_bayar').attr('disabled', 'disabled');
                var hasilString = "Rp." + hasil;
            } else if (hasil == 0) {
                hasil = 0
                $('#btn_bayar').removeAttr("disabled");
                var hasilString = 'Uang Pas';
            } else {
                $('#btn_bayar').removeAttr("disabled");
                var hasilString = hasil;
            }


            $('#kembalian').val(hasilString)
            $('#kembalian2').val(hasil)
        })


        const detailBayar = (id) => {
            $.get(`${MY_URL}/kasir/getDetailBayar/${id}`, (data, status) => {
                console.log(data);
                data.data.detailBayar.forEach((val, i) => {
                    var hasil =
                        `"
                            <tr role="row" class="text-center">
                                <td>${val.nama_hewan}</td>
                                <td>${val.nama_jasa}</td>
                                <td>${val.harga_jasa}</td>
                            </tr>
                            "`;
                    $("#table-bayar").append(hasil);
                });
                $('#total_bayar_cs').val(data.data.total)
                $('#pemilik').val(id)
                $('#total_bayar_lihat').val("Rp." + data.data.total)
                $('#pemilik_judul').append(
                    `<h4 class="text-black h4">Pemilik : ${data.data.detailBayar[0].nama_lengkap} </h4>`)
            })
        }
    </script>
    <script src="{{ asset('aset/vendors/scripts/datatable-setting.js') }}"></script>
@endsection
@section('content')

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Halaman Tagihan Jasa</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Tagihan Pembayaran Jasa
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                        </div>
                    </div>
                </div>
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-black h4">Data Jasa Yang Belum Dibayar</h4>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th class="table-plus">#</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Hewan</th>
                                        <th>Total Bayar</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($tagihan) && $tagihan != null)
                                        <?php $i = 1; ?>
                                        @foreach ($tagihan as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->nama_pemilik }}</td>
                                                <td>{{ $item->nama_hewan }}</td>
                                                <td>@currency($item->total_bayar)</td>
                                                <td>
                                                    <button id="proses_bayar_jasa" data-id="{{ $item->pemilik }}"
                                                        class="btn btn-primary"><i
                                                            class="icon-copy dw dw-shopping-cart1"></i></button>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Simple Datatable End -->
            </div>
            @include('components.footer')

            @include('modals.jasa.pembayaran_jasa')
        </div>
    </div>
@endsection
