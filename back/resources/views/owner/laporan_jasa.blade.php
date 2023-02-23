@extends('layouts.master', ['laporan_jasa' => 'active', 'title' => 'Laporan Jasa | '])
@section('head')
@stop

@section('jsFooter')
    <script src="{{ asset('aset/proses/owner.js') }}"></script>
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
                                <h4>Halaman Laporan Jasa</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Data Laporan Jasa
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                        </div>
                    </div>
                </div>

                {{-- masukkan filter --}}
                <div class="card-box mb-30">
                    <form action="" method="get">
                        <div class="pd-20">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <h2 class="text-black">Cari Laporan Jasa</h2>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="text-black h4 mb-2">Pilih Bulan & Tahun</h4>
                                    <div class="form-group">
                                        <input type="text" name="select_bulan"
                                            value="{{ isset($_GET['select_bulan']) ? $_GET['select_bulan'] : '' }}"
                                            class="month-picker form-control" id="select_bulan">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="text-black h4 mb-2">Pilih Tanggal Awal</h4>
                                    <div class="form-group">
                                        <input type="text" class="date-picker form-control" name="range_tanggal_start"
                                            value="{{isset($_GET['range_tanggal_start']) ? $_GET['range_tanggal_start'] : ''}}" id="range_tanggal_start">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="text-black h4 mb-2">Pilih Tanggal Akhir</h4>
                                    <div class="form-group">
                                        <input type="text" class="date-picker form-control" name="range_tanggal_end"
                                            value="{{isset($_GET['range_tanggal_end']) ? $_GET['range_tanggal_end'] : ''}}" id="range_tanggal_end">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4 class="text-black h4 mb-2">Action</h4>
                                    <div class="form-group">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">
                                            <span class="icon-copy ti-search"></span>
                                            Cari
                                        </button>
                                        <button id="resetBtnFilter" class="btn btn-sm btn-outline-warning" type="button">
                                            <i class="icon-copy fa fa-refresh" aria-hidden="true"></i>
                                            Reset
                                        </button>
                                        <a href="{{ route('owner.laporan-penjualan') }}"
                                            class="btn btn-sm btn-outline-success" type="button">
                                            <i class="icon-copy fa fa-refresh" aria-hidden="true"></i>
                                            Refresh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- akhir masukkan filter --}}
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-black h4">Data Laporan Penjualan</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle waves-effect"
                                    data-toggle="dropdown" aria-expanded="false">
                                    Export Data <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <form action="{{route('exportPDFTransaksiJasa')}}" target="_blank" method="get">
                                        <input type="hidden" name="filter_bulan_pdf" value="{{isset($key_bulan) ? $key_bulan : ''}}" id="filter_bulan_pdf">
                                        <input type="hidden" name="filter_range1_pdf" value="{{isset($key_range1) ? $key_range1 : ''}}" id="filter_range1_pdf">
                                        <input type="hidden" name="filter_range2_pdf" value="{{isset($key_range2) ? $key_range2 : ''}}" id="filter_range2_pdf">
                                        <button type="submit" class="btn-sm dropdown-item" href="">Export PDF</button>
                                    </form>
                                    <form action="{{route('exportTransaksiJasa')}}" target="_blank" method="get">
                                        <input type="hidden" name="filter_bulan_xls" value="{{isset($key_bulan) ? $key_bulan : ''}}" id="filter_bulan_xls">
                                        <input type="hidden" name="filter_range1_xls" value="{{isset($key_range1) ? $key_range1 : ''}}" id="filter_range1_xls">
                                        <input type="hidden" name="filter_range2_xls" value="{{isset($key_range2) ? $key_range2 : ''}}" id="filter_range2_xls">
                                        <button class="btn-sm dropdown-item">Export Excel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th class="table-plus">#</th>
                                        <th>Kode Transaksi</th>
                                        <th>Nama Jasa</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Total Harga</th>
                                        <th>Kasir</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($laporan) && $laporan != null)
                                        <?php $i = 1; ?>
                                        @foreach ($laporan as $p)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $p->kode_transaksi_jasa }}</td>
                                                <td>{{ $p->jasa->nama_jasa }}</td>
                                                <td>{{ date('d-M-Y', strtotime($p->tanggal_transaksi_jasa)) }}</td>
                                                <td>@currency($p->total_harga_jasa)</td>
                                                <td>{{ $p->user->nama_lengkap }}</td>
                                                <td>
                                                    <a href="" class="btn btn-outline-danger" id="hapus_laporan">
                                                        <i class="dw dw-delete-3"></i>
                                                    </a>
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
        </div>
    </div>

@endsection
