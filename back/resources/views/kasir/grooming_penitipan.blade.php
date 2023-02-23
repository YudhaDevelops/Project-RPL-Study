@extends('layouts.master', ['grooming_penitipan' => 'active', 'title' => 'Jasa Grooming Penitipan | '])
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/vendors/styles/style.css') }}" />
@stop
@section('jsFooter')
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
                                <h4>Halaman Jasa</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Add Jasa Grooming & Penitipan
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
                                                <form action="{{route('jasa.saveGroomingPenitipan')}}" method="POST">
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
                                                                <label>Tanggal Grooming & Tanggal Masuk Penitipan</label>
                                                                <input class="form-control form-control-lg date-picker"
                                                                    type="" name="tanggal">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Jenis Grooming</label>
                                                                <select name="jenis_grooming" id=""
                                                                    class="form-control">
                                                                    <option value="" selected readonly id="">
                                                                        Pilih Jenis Grooming</option>
                                                                    @if (isset($grooming) && $grooming != null)
                                                                        @foreach ($grooming as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->nama_jasa }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nomor Kandang Penitipan</label>
                                                                <input class="form-control form-control-lg"
                                                                    type="number" name="nomor_kandang" value=""/>
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
                                                                    <label>Waktu Masuk Grooming</label>
                                                                    <input
                                                                        class="form-control form-control-lg time-picker-default"
                                                                        name="waktu_masuk">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label>Waktu Keluar Grooming</label>
                                                                    <input
                                                                        class="form-control form-control-lg time-picker-default"
                                                                        name="waktu_keluar">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Harga Jasa Grooming</label>
                                                                <input type="hidden" name="harga_grooming" id="harga">
                                                                <input id="harga_grooming"
                                                                    class="form-control form-control-lg" readonly
                                                                    type="text" value="" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tanggal Keluar Penitipan</label>
                                                                <input class="form-control form-control-lg datetimepicker" name="tanggal_keluar">
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
            </div>
            @include('components.footer')
        </div>
    </div>
    
@endsection
