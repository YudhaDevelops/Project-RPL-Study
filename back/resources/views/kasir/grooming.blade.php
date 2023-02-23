@extends('layouts.master', ['grooming' => 'active', 'title' => 'Jasa Grooming | '])
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/vendors/styles/style.css') }}" />
@stop
@section('jsFooter')
    <script src="{{ asset('aset/proses/kasir.js') }}"></script>
    <script>
        $('body').on('click', '#selesai_grooming', function(e) {
            e.preventDefault();

            var link = $(this).attr('href');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Untuk Grooming Pada Hewan Ini Sudah Selesai?",
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
                    )
                }
            })
        })

        $('body').on('click', '#hapus_data_grooming', function(e) {
            e.preventDefault();

            var link = $(this).attr('href');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Untuk Menghapus Data Ini?",
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
                                <h4>Halaman Jasa</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Jasa Grooming
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                        </div>
                    </div>
                </div>

                <!-- Start Tambah data -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#grooming" role="tab">
                                                Add Data
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- Setting Tab start -->
                                        <div class="tab-pane fade show active height-100-p" id="grooming" role="tabpanel">
                                            <div class="profile-setting">
                                                <form action="{{ route('jasa.save.grooming') }}" method="POST">
                                                    @csrf
                                                    <ul class="profile-edit-list row">
                                                        <li class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Nama Hewan</label>
                                                                <select class="form-control custom-select2" name="id_hewan">
                                                                    <option value=""selected>Pilih hewan</option>
                                                                    @if (isset($userHewan) && $userHewan != null)
                                                                        @foreach ($userHewan as $d)
                                                                            <option value="{{ $d->id_hewan }}">
                                                                                {{ $d->nama_hewan }} -
                                                                                {{ $d->nama_lengkap }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tanggal</label>
                                                                <input class="form-control form-control-lg date-picker"
                                                                    type="" name="tanggal">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Jenis Grooming</label>
                                                                <select name="jenis_grooming" id=""
                                                                    class="form-control">
                                                                    <option value="" selected readonly id="">
                                                                        Pilih Jenis Grooming</option>
                                                                    @if (isset($jasa) && $jasa != null)
                                                                        @foreach ($jasa as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->nama_jasa }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </li>
                                                        <li class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Nama Customer</label>
                                                                <input id="nama_customer"
                                                                    class="form-control form-control-lg" name="nama_lengkap"
                                                                    readonly type="text" value="" />
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-6">
                                                                    <label>Waktu Masuk</label>
                                                                    <input
                                                                        class="form-control form-control-lg time-picker-default"
                                                                        name="waktu_masuk">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label>Waktu Keluar</label>
                                                                    <input
                                                                        class="form-control form-control-lg time-picker-default"
                                                                        name="waktu_keluar">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Harga Jasa</label>
                                                                <input type="hidden" name="harga_grooming" id="harga">
                                                                <input id="harga_grooming"
                                                                    class="form-control form-control-lg" readonly
                                                                    type="text" value="" />
                                                            </div>
                                                        </li>
                                                        <div class="weight-500 col-md-12 text-center">
                                                            <div class="form-group mb-0">
                                                                <input type="submit" class="btn btn-primary"
                                                                    value="Create Data" />
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Setting Tab End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Tambah data -->
                <!-- Simple Datatable start -->
                <div class="card-box mb-30">
                    <div class="pd-20">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-black h4">Data Proses Grooming</h4>
                            </div>
                            {{-- <div class="col-sm-6 text-right">
                                <div class="btn btn-outline-primary">Export</div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th>Nama Hewan</th>
                                        <th>Jenis Grooming</th>
                                        <th>Harga</th>
                                        <th>Pemilik</th>
                                        <th>Tahapan</th>
                                        <th>Tanggal</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($grooming) && $grooming != null)
                                        @foreach ($grooming as $item)
                                            <tr>
                                                <td>{{ $item->nama_hewan }}</td>
                                                <td>{{ $item->nama_jasa }}</td>
                                                <td>@currency($item->harga_jasa)</td>
                                                <td>{{ $item->nama_lengkap }}</td>
                                                <td>{{ $item->tahapan }}</td>
                                                <td>{{ date('d F Y', strtotime($item->tanggal_grooming)) }}</td>
                                                <td>{{ date('H:i', strtotime($item->waktu_masuk)) }}</td>
                                                <td>{{ date('H:i', strtotime($item->waktu_keluar)) }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                            href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div
                                                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#edit_modal_grooming_{{ $item->id_grooming }}">
                                                                <i class="dw dw-edit2"></i>
                                                                Edit Data
                                                            </button>
                                                            <a class="dropdown-item" href="{{ route('jasa.grooming-selesai', ['id' => $item->id_grooming]) }}"
                                                                id="selesai_grooming">
                                                                <i class="icon-copy bi bi-check2-square"></i>Selesai Proses
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('delete.grooming-delete', ['id' => $item->id_grooming]) }}"
                                                                id="hapus_data_grooming">
                                                                <i class="dw dw-delete-3"></i>
                                                                Delete Data
                                                            </a>
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
            @include('modals.jasa.edit_modal_grooming')
        </div>
    </div>
    
@endsection
