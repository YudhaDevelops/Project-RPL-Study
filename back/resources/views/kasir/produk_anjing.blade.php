@extends('layouts.master', ['produk_anjing' => 'active', 'title' => 'Produk Makanan Anjing | '])
@section('head')
    <!-- bootstrap-tagsinput css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <!-- bootstrap-touchspin css -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('aset/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/cropperjs/dist/cropper.css') }}" />
@stop

@section('jsFooter')
    <script src="{{ asset('aset/src/plugins/cropperjs/dist/cropper.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('aset/proses/kasir.js') }}"></script>
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
                                <h4>Halaman Produk</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Produk Makanan Anjing
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
                                <h4 class="text-black h4">Data Produk</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#create_modal_produk_anjing">
                                    Add Produk
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle waves-effect"
                                    data-toggle="dropdown" aria-expanded="false">
                                    Export Data <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="btn-sm dropdown-item" target="_blank" href="{{route('exportPDFProdukAnjing')}}">Export PDF</a>
                                    <a class="btn-sm dropdown-item" target="_blank" href="{{route('exportProdukAnjing')}}">Export Excel</a>
                                    <a class="btn-sm dropdown-item" target="_blank" href="{{route('exportProdukSemua')}}">Export Excel Semua Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th class="table-plus">Id Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Bobot</th>
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th>Gambar Produk</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data != null)
                                        @foreach ($data as $p)
                                            <tr>
                                                <td>{{ $p->kode_produk }}</td>
                                                <td>{{ $p->nama_produk }}</td>
                                                <td>{{ $p->bobot }} gram</td>
                                                <td> @currency($p->harga)</td>
                                                <td>{{ $p->stok }}</td>
                                                <td>
                                                    @if (isset($p->gambar_produk))
                                                        <img src="{{ $p->gambar_produk }}" width="50px" alt="gambar">
                                                </td>
                                            @else
                                                Belum Di Set
                                        @endif
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                    href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <button class="dropdown-item" data-toggle="modal"
                                                        data-target="#show_modal_produk_anjing_{{ $p->id }}">
                                                        <i class="dw dw-eye"></i> View</button>
                                                    <button class="dropdown-item" data-toggle="modal"
                                                        data-target="#edit_modal_produk_anjing_{{ $p->id }}">
                                                        <i class="dw dw-edit2"></i> Edit</button>
                                                    <a class="dropdown-item"
                                                        href="{{ route('anjing.delete', ['id' => $p->id]) }}"
                                                        id="hapus_anjing">
                                                        <i class="dw dw-delete-3"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        </tr>
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
            <!-- modal tambah data -->
            @include('modals.produk.create_produk_anjing')
            <!-- modal show data -->
            @include('modals.produk.show_produk_anjing')
            <!-- modal edit data -->
            @include('modals.produk.edit_produk_anjing')
        </div>
    </div>

@endsection
