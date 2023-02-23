@extends('layouts.master', ['penjualan' => 'active', 'title' => 'Jual Produk | '])
@section('head')
    <!-- bootstrap-tagsinput css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <!-- switchery css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/switchery/switchery.min.css') }}" />
    <!-- bootstrap-touchspin css -->
    <link rel="stylesheet"
        type="text/css"href="{{ asset('aset/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}">
@endsection
@section('jsHead')
@endsection
@section('jsFooter')
    <script src="{{ asset('aset/vendors/scripts/datatable-setting.js') }}"></script>
    <!-- switchery js -->
    <script src="{{ asset('aset/src/plugins/switchery/switchery.min.js') }}"></script>
    <!-- bootstrap-tagsinput js -->
    <script src="{{ asset('aset/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <!-- bootstrap-touchspin js -->
    <script src="{{ asset('aset/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('aset/proses/kasir.js') }}"></script>
@endsection
@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Halaman Jasa</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Penjualan Produk
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
                    <div class="pd-5">
                        <div class="row my-3 mx-3 pt-3">
                            <div class="col-sm-4">
                                <h4 class="text-black h4">Tanggal : {{ $tanggal }}</h4>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select class="custom-select2 form-control form-control-lg" name="pilih_produk">
                                        <option value="" selected disabled>Piih Produk</option>
                                        @if (isset($produk) && $produk != null)
                                            @foreach ($produk as $item)
                                                @if ($item->stok == '0')
                                                    <option disabled value="{{ $item->kode_produk }}">
                                                        {{ $item->nama_produk }} (Stok : Stok Habis)</option>
                                                @else
                                                    <option value="{{ $item->kode_produk }}">{{ $item->nama_produk }}
                                                        (Stok : {{ $item->stok }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a href="{{route('kasir.jual-produk')}}" class="btn btn-sm btn-outline-success">
                                    <i class="icon-copy fa fa-refresh" aria-hidden="true"></i>
                                    Refresh
                                </a>
                                <a href="{{ route('delete.reset_keranjang') }}" type="button"
                                    class="btn btn-sm btn-outline-danger">
                                    Reset Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr class=" text-center">
                                        <th class="table-plus">No</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Total Harga</th>
                                        <th>Kasir</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($keranjang) && $keranjang != null)
                                        <?php $i = 1; ?>
                                        @foreach ($keranjang as $item)
                                            <tr>
                                                <td>
                                                    {{ $i }}
                                                </td>
                                                <td>
                                                    {{ $item->kode_produk }}
                                                </td>
                                                <td>
                                                    {{ $item->nama_barang }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->jumlah_barang }}
                                                </td>
                                                <td>
                                                    @currency($item->harga)
                                                </td>
                                                <td>
                                                    @currency($item->harga_total)
                                                </td>
                                                <td>
                                                    {{ $item->nama_kasir }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-small-success"
                                                        id="tambah_jumlah_barang" data-id="{{ $item->kode_produk }}">
                                                        <i class="icon-copy fi-plus"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-small-warning"
                                                        id="kurang_jumlah_barang" data-id="{{ $item->kode_produk }}">
                                                        <i class="icon-copy fi-minus"></i>
                                                    </button>
                                                    <a href="{{ route('delete.delete_keranjang', ['id' => $item->id]) }}"
                                                        id="hapus_data_keranjang" class="btn btn-danger btn-small-danger"
                                                        data-toggle="tooltip" data-placement="top" title="Delete Barang">
                                                        <i class="icon-copy bi bi-trash3-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            {{-- total semua --}}
                            <hr>
                            <form action="{{ route('kasir.transaksi-produk') }}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="id_transaksi" value="{{ $id_transaksi }}">
                                <div class="row mt-5">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group ml-3 float-left row">
                                            <label class="my-2">Total Semua : </label>
                                            <div class="col-md-8">
                                                <input type="hidden" name="total_bayar" id="total_bayar_cs"
                                                    value="{{ isset($total_bayar) ? $total_bayar : '0' }}">
                                                <input class="form-control" style="width: 250px" type="text"
                                                    value="@currency($total_bayar)" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group  row float-right pr-3">
                                            <label class="my-2">Bayar : </label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="user_membayar" id="user_membayar"
                                                    style="width: 250px" type="text" value="">
                                            </div>
                                            <button href="#" id="btn_bayar" disabled class="btn btn-outline-primary"
                                                type="button submit">
                                                <i class="icon-copy dw dw-shopping-cart1"></i>
                                                Bayar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-1">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group ml-3 float-left row">
                                            <label class="my-2">Kembali : </label>
                                            <div class="col-md-8">
                                                <input type="hidden" name="kembalian" id="kembalian2">
                                                <input class="form-control" id="kembalian" style="width: 250px"
                                                    type="text" value="Rp. " readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        {{-- <div class="form-group  row float-right pr-3">
                                            <div class="co-md-12">
                                                <a href="{{ route('pdf.print_nota', ['id_transaksi' => $id_transaksi]) }}"
                                                    target="_blank" class="btn btn-outline-info" type="button">Print
                                                    Untuk Bukti Pebayaran</a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                {{-- <input type="hidden submit" name=""> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Simple Datatable End -->
            </div>
            @include('components.footer')
            {{-- modal cari barang --}}
            @include('modals.transaksi.modal_cari_barang')
        </div>
    </div>
@endsection
