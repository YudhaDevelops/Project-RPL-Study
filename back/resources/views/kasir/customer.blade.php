@extends('layouts.master', ['customer' => 'active', 'title' => 'Customer | '])
@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/cropperjs/dist/cropper.css') }}" />
@endsection

@section('jsFooter')
    <script src="{{ asset('aset/vendors/scripts/datatable-setting.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/cropperjs/dist/cropper.js') }}"></script>
    <script src="{{ asset('aset/proses/proses.js') }}"></script>
@endsection
@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Halaman Customer</h4>
                            </div>
                            @if (session('errors'))
                                <div id="error" data-title="Something it's wrong"></div>
                            @endif
                            @if (session('sukses'))
                                <div id="sukses" data-sukses="{{ session()->get('sukses') }}"></div>
                            @endif
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Data Customer
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
                                <h4 class="text-black h4">Data Customer</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle waves-effect"
                                    data-toggle="dropdown" aria-expanded="false">
                                    Export <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_blank" href="{{route('exportPDFCustomer')}}">PDF</a>
                                    <a class="dropdown-item" target="_blank" href="{{route('exportCustomer')}}">Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        {{-- <th class="table-plus">#</th> --}}
                                        <th>Nama Customer</th>
                                        <th>Nomor Telepon</th>
                                        <th>Nama Hewan</th>
                                        <th>Jenis Hewan</th>
                                        <th>Umur Hewan</th>
                                        <th>Gambar Hewan</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($customer != null)
                                        @foreach ($customer as $p)
                                            <tr>
                                                <td>{{ $p->nama_lengkap }}</td>
                                                <td>{{ $p->no_telepon }}</td>
                                                <td>{{ $p->nama_hewan }}</td>
                                                <td>{{ $p->tipe_hewan }}</td>
                                                <td>{{ $p->umur_hewan }}</td>
                                                <td>
                                                    @if (isset($p->gambar_hewan))
                                                        <img src="{{ $p->gambar_hewan }}" width="50px" alt="gambar">
                                                    @else
                                                        Belum Di Set
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                            href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div
                                                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#update_hewan_{{ $p->id_hewan }}">
                                                                <i class="dw dw-edit2"></i>
                                                                Edit Hewan
                                                            </button>
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#update_modal_customer_{{ $p->id_user }}">
                                                                <i class="dw dw-edit2"></i>
                                                                Edit Pemilik
                                                            </button>
                                                            <a class="dropdown-item"
                                                                href="{{ route('delete.delete-hewan', ['id' => $p->id_hewan]) }}"id="hapus_hewan">
                                                                <i class="dw dw-delete-3"></i>
                                                                Delete Hewan
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('delete.customer', ['id' => $p->id_user]) }}"id="hapus_customer">
                                                                <i class="dw dw-delete-3"></i>
                                                                Delete Pemilik & Hewan
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
            <!-- Start Tambah data -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
                    <div class="card-box height-100-p overflow-hidden">
                        <div class="profile-tab height-100-p">
                            <div class="tab height-100-p">
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#hewan" role="tab">Add
                                            Hewan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#pemilik" role="tab">Add Pemilik</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- Hewan Tab start -->
                                    <div class="tab-pane fade show active height-100-p" id="hewan" role="tabpanel">
                                        <div class="profile-setting">
                                            <form action="{{ route('hewan.create-hewan') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama Hewan</label>
                                                            <input type="text" name="nama_hewan" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jenis Hewan</label>
                                                            <div class="d-flex">
                                                                <div class="custom-control custom-radio mb-5 mr-20">
                                                                    <input type="radio" id="anjing"
                                                                        name="jenis_hewan" value="Anjing"
                                                                        class="custom-control-input" />
                                                                    <label class="custom-control-label weight-400"
                                                                        for="anjing">Anjing</label>
                                                                </div>
                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="kucing"
                                                                        name="jenis_hewan" value="Kucing"
                                                                        class="custom-control-input" />
                                                                    <label class="custom-control-label weight-400"
                                                                        for="kucing">Kucing</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group row">
                                                            <div class="col-6">
                                                                <label for="umur_hewan">Umur Hewan</label>
                                                                <input type="number" name="umur_hewan"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Gambar Hewan</label>
                                                                <input type="hidden" name="gambar_hewan"
                                                                    id="gambar_hewan_send">
                                                                <input type="file" class="form-control" name=""
                                                                    id="gambar_hewan">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pemilik">Nama Pemilik</label>
                                                            <select name="nama_pemilik"
                                                                class="custom-select2 form-control" id="nama_pemilik"
                                                                style="width: 100%; height: 38px">
                                                                <option value="" selected disabled>Pilih Pemilik
                                                                </option>
                                                                @if (isset($user) && $user != null)
                                                                    @foreach ($user as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->nama_lengkap }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                    </li>
                                                    <div class="weight-500 col-md-12 text-center">
                                                        <div class="form-group mb-0">
                                                            <input type="submit" class="btn btn-primary"
                                                                value="Create Hewan" />
                                                        </div>
                                                    </div>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Hewan Tab End -->

                                    <!-- pemilik  Tab start -->
                                    <div class="tab-pane fade height-100-p" id="pemilik" role="tabpanel">
                                        <div class="profile-setting">
                                            <form action="{{ route('kasir.add.customer') }}" method="POST">
                                                @csrf
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label for="nama_lengkap">Nama Pemilik</label>
                                                            <input type="text" class="form-control"
                                                                name="nama_lengkap" id="nama_lengkap">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Gender</label>
                                                            <div class="d-flex">
                                                                <div class="custom-control custom-radio mb-5 mr-20">
                                                                    <input type="radio" id="customRadio4"
                                                                        name="gender" value="Laki-laki"
                                                                        class="custom-control-input" />
                                                                    <label class="custom-control-label weight-400"
                                                                        for="customRadio4">Laki-Laki</label>
                                                                </div>
                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="customRadio5"
                                                                        name="gender" value="Perempuan"
                                                                        class="custom-control-input" />
                                                                    <label class="custom-control-label weight-400"
                                                                        for="customRadio5">Perempuan</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input class="form-control form-control-lg" name="no_telepon"
                                                                type="text" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email"class="form-control" name="email"
                                                                id="email" name="email">
                                                        </div>
                                                    </li>
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label>Provinsi</label>
                                                            <select class="custom-select2 form-control"id="provinsi"
                                                                name="provinsi" style="width: 100%; height: 38px">
                                                                <option value="#" selected disabled>Provinsi</option>
                                                                @if (isset($data) && $data != null)
                                                                    <option value="{{ $data->id }}"
                                                                        {{ isset($modalCustomer->provinsi) ? 'selected' : '' }}>
                                                                        {{ $data->nama }}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kabupaten</label>
                                                            <select id="kabupaten" name="kabupaten"
                                                                class="custom-select2 form-control"
                                                                style="width: 100%; height: 38px">
                                                                <option value="" selected>Kabupaten</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kecamatan</label>
                                                            <select id="kecamatan" name="kecamatan"
                                                                class="custom-select2 form-control"
                                                                style="width: 100%; height: 38px">
                                                                <option value="" selected>Kecamatan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kelurahan</label>
                                                            <select id="kelurahan" name="kelurahan"
                                                                class="custom-select2 form-control"
                                                                style="width: 100%; height: 38px">
                                                                <option value="" selected>Kelurahan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Detail Alamat</label>
                                                            <textarea name="detail_alamat" class="form-control"></textarea>
                                                        </div>
                                                    </li>
                                                    <div class="weight-500 col-md-12 text-center">
                                                        <div class="form-group mb-0">
                                                            <input type="submit" class="btn btn-primary"
                                                                value="Create Pemilik" />
                                                        </div>
                                                    </div>
                                                </ul>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- pemilik  Tab End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tambah data -->
            @include('components.footer')
            {{-- edit hewan --}}
            @include('modals.users.edit_hewan')
            {{-- edit customer --}}
            @include('modals.users.edit_customer')

            {{-- modal --}}
            <div class="modal fade" id="modal_image" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body pd-5">
                            <div class="img-container">
                                <img id="image_modal" src="" alt="Picture" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="btn_crop_image">
                                Crop
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- akhir modal --}}
        </div>
    </div>

@endsection
