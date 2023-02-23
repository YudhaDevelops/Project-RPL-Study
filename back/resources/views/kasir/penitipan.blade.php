@extends('layouts.master', ['penitipan' => 'active', 'title' => 'Jasa Penitipan | '])
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/jquery-steps/jquery.steps.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/vendors/styles/style.css') }}" />
@endsection
@section('jsHead')
@endsection
@section('jsFooter')
    <script src="{{ asset('aset/proses/kasir.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/jquery-steps/jquery.steps.js') }}"></script>
    <script src="{{ asset('aset/vendors/scripts/steps-setting.js') }}"></script>
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
                                        Jasa Penitipan
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
                                <div class="col-sm-6 mt-30">
                                    <h4 class="text-black h4">Tambah Data Penitipan</h4>
                                </div>
                                <!-- <div class="col-sm-6 text-right"> -->
                                    <!-- <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#setting"
                                                role="tab">Personal Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#password"
                                                role="tab">Password Setting</a>
                                        </li>
                                    </ul> -->
                                    <div class="tab-content">
                                        <!-- Setting Tab start -->
                                        <div class="tab-pane fade show active height-100-p" id="setting" role="tabpanel">
                                            <div class="profile-setting">
                                                <form action="{{route('jasa.save.penitipan')}}" method="POST">
                                                    @csrf
                                                    <ul class="profile-edit-list row">
                                                        <li class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Nama Hewan</label>
                                                                <select class="form-control form-control-lg custom-select2" name="id_hewan">
                                                                    <option value=""selected>Pilih hewan</option>
                                                                    @if(isset($data) && $data != null)
                                                                        @foreach($data as $d)
                                                                            <option value="{{$d->id_hewan}}">{{$d->nama_hewan}} - {{$d->nama_lengkap}}</option>
                                                                        @endforeach
                                                                    @endif                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tanggal Masuk</label>
                                                                <input class="form-control form-control-lg datetimepicker" type="" name="tanggal_masuk">                                                                    
                                                            </div>                                                            
                                                            <div class="form-group">
                                                                <label>Nomor Kandang</label>
                                                                <input class="form-control form-control-lg"
                                                                    type="number" name="nomor_kandang" value=""/>
                                                            </div>
                                                        </li>
                                                        <li class="weight-500 col-md-6">
                                                            <div class="form-group">
                                                                <label>Nama Customer</label>
                                                                <input id="nama_customer" class="form-control form-control-lg" name="nama_lengkap" readonly type="text" value="" />
                                                            </div>
                                                            
                                                            
                                                            <div class="form-group">
                                                                <label>Tanggal Keluar</label>
                                                                <input class="form-control form-control-lg datetimepicker" name="tanggal_keluar">
                                                            </div>                                                            
                                                        </li>
                                                        <div class="weight-500 col-md-12 text-center">
                                                            <div class="form-group mb-0">
                                                                <input type="submit" class="btn btn-primary"
                                                                    value="Add Data" />
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Setting Tab End -->

                                        <!-- password Setting Tab start -->
                                        <div class="tab-pane fade height-100-p" id="password" role="tabpanel">
                                            <div class="profile-setting">
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-12">
                                                        <h4 class="text-blue h5 mb-20">
                                                            Edit Password Account
                                                        </h4>
                                                        <form action="" method="POST">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>Password Baru</label>
                                                                <input class="form-control form-control-lg" type="text"
                                                                    value="" disabled/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Password Baru</label>
                                                                <input class="form-control form-control-lg" name="password" type="password"
                                                                    placeholder="Password baru" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Konfirmasi Password</label>
                                                                <input class="form-control form-control-lg" name="password_confirmation" type="password"
                                                                    placeholder="Konfirmasi password baru" />
                                                            </div>
                                                            <div class="form-group mb-0">
                                                                <input type="submit" class="btn btn-primary"
                                                                    value="Save & Update" />
                                                            </div>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- password Setting Tab End -->
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
                                <h4 class="text-black h4">Data Proses Penitipan</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <!-- <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                    data-target="#create_modal_jasa_penitipan">
                                    Add Data
                                </button> -->
                                {{-- <div class="btn btn-outline-primary">Export</div> --}}
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
                                        <th>Nomor Kandang</th>
                                        <th>Durasi</th>
                                        <th>Harga</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if ($penitipanAll != null)
                                <?php $i = 1; ?>
                                        @foreach ($penitipanAll as $p)
                                            <tr>
                                                <td>{{ $i }}</td> 
                                                <td>{{ $p->nama_lengkap }}</td>
                                                <td>{{ $p->nama_hewan }}</td>
                                                <td>{{ $p->no_kandang }}</td>
                                                <td>{{ $p->durasi}}</td>
                                                <td>{{ $p->hargaPenitipanTotal}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                            href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div
                                                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#show_penitipan_{{ $p->id }}">
                                                                <i class="dw dw-eye"></i> View</button>
                                                            <a class="dropdown-item" href="{{route('penitipan.selesai', ['id' => $p->id_penitipan, 'durasi' => $p->durasiAngka])}}">
                                                                <i class="icon-copy bi bi-check2-square"></i>Selesaikan</a>
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="">
                                                                <i class="dw dw-eye"></i> Transaksi</button>
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#edit_penitipan_{{ $p->id }}">
                                                                <i class="dw dw-edit2"></i> Edit</button>
                                                            <a class="dropdown-item"
                                                                href="{{ route('penitipan.delete', ['id' => $p->id_penitipan]) }}"
                                                                id="hapus_penitipan">
                                                                <i class="dw dw-delete-3"></i> Delete</a>
                                                        </div>
                                                    </div>
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
            <!-- modal tambah data -->
            @include('modals.jasa.create_jasa_penitipan')
            <!-- modal show data -->
            @include('modals.jasa.show_penitipan')
            <!-- modal edit data -->
            @include('modals.jasa.edit_penitipan')
        </div>
    </div>
@endsection
