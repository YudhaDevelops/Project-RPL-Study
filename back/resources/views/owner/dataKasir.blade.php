@extends('layouts.master', ['dataKasir' => 'active', 'title' => 'Data Account Kasir | '])
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
                                <h4>Halaman Data Kasir</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Data Account Kasir
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
                                <h4 class="text-black h4">Data Kasir</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                    data-target="#create_modal_kasir">
                                    Add Data
                                </button>
                                <div class="btn btn-outline-primary">Export</div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th class="table-plus">#</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Nomor Telepon</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($kasir) && $kasir != null)
                                    <?php $i = 1 ?>
                                        @foreach ($kasir as $p)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $p->nama_lengkap }}</td>
                                                <td>{{ $p->email }}</td>
                                                <td>{{ $p->gender }}</td>
                                                <td>{{ $p->no_telepon }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                            href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div
                                                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#edit_modal_kasir_{{ $p->id }}">
                                                                <i class="dw dw-edit2"></i> Edit</button>
                                                            <a class="dropdown-item"
                                                                href="{{ route('delete.delete-account-kasir', ['id' => $p->id]) }}"
                                                                id="hapus_kasir">
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
            @include('modals.users.create_kasir')
            <!-- modal edit data -->
            @include('modals.users.edit_kasir')
        </div>
    </div>

@endsection
