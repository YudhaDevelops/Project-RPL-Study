@extends('layouts.master', ['profile' => 'active', 'title' => 'Profile Settings | '])
@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/cropperjs/dist/cropper.css') }}" />
    <style>
        .upload_profile {
            display: none;
        }
    </style>
@endsection
@section('jsFooter')
    <script>
        @if (session()->has('success'))
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
                title: `{{ session()->get('success') }}`,
            })
        @endif
        @if (session('errors'))
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
                title: `{{ session()->get('errors')->first() }}`,
            })
        @endif

        $('#btn-image-profile').on('click', function() {
            $('#upload_profile').click();
        })
    </script>
    <script src="{{ asset('aset/proses/owner.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/cropperjs/dist/cropper.js') }}"></script>
    <script>
        var $modal = $('#modal_image');
        var image = document.getElementById('image_modal');
        var cropper;

        $("body").on("change", "#upload_profile", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modal.on("shown.bs.modal", function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
            image.src = '';
            $('#upload_profile').val('');
        });
        $("#btn_crop_image").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "upload-foto-profile",
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data
                        },
                        success: function(data) {
                            location.reload();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: `${data.message}`,
                            })
                        },
                        error: function(error) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: `${error.message}`,
                            })
                        }
                    });
                }
            });
        })
    </script>
@endsection
@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Profile</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Profile
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="profile-photo">
                                <input type="file" name="foto_profile" class="upload_profile" id="upload_profile">
                                <button class="edit-avatar" id="btn-image-profile">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                {{-- <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar">
                                    <i class="fa fa-pencil"></i>
                                </a> --}}
                                <img src="{{ isset($data->foto_profile) ? asset('profile/'.$data->foto_profile) : 'https://i.ibb.co/6RXKvM5/img.jpg'}}" alt="" class="avatar-photo" />
                                {{-- modal --}}
                                <div class="modal fade" id="modal_image" data-backdrop="static" tabindex="-1"
                                    role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body pd-5">
                                                <div class="img-container">
                                                    <img id="image_modal" src="" alt="Picture" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" id="btn_crop_image">
                                                    Crop & Update
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
                            <h5 class="text-center h5 mb-0">{{ isset($data->nama_lengkap) ? $data->nama_lengkap : '' }}</h5>
                            <p class="text-center text-muted font-14">
                                @if ($data->role == 1)
                                    Kasir
                                @else
                                    Owner
                                @endif
                            </p>
                            <div class="profile-info">
                                <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                                <ul>
                                    <li>
                                        <span>Email Address:</span>
                                        {{ isset($data->email) ? $data->email : '' }}
                                    </li>
                                    <li>
                                        <span>Phone Number:</span>
                                        {{ isset($data->no_telepon) ? $data->no_telepon : '' }}
                                    </li>
                                    <li>
                                        <span>Address:</span>
                                        {{ $data->detail_alamat }}, {{ $data->kelurahan }}, {{ $data->kecamatan }},
                                        {{ $data->provinsi }}<br />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                        <div class="card-box height-100-p overflow-hidden">
                            <div class="profile-tab height-100-p">
                                <div class="tab height-100-p">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#setting"
                                                role="tab">Personal Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#password" role="tab">Password
                                                Setting</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- Setting Tab start -->
                                        <div class="tab-pane fade show active height-100-p" id="setting" role="tabpanel">
                                            <div class="profile-setting">
                                                @if (Auth::user()->role == 1)
                                                    <form action="{{ route('kasir.update-profile', ['id' => $data->id]) }}"
                                                        method="POST">
                                                    @else
                                                        <form
                                                            action="{{ route('owner.update-profile', ['id' => $data->id]) }}"
                                                            method="POST">
                                                @endif
                                                @method('PUT')
                                                @csrf
                                                <ul class="profile-edit-list row">
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama Lengkap</label>
                                                            <input class="form-control form-control-lg" name="nama_lengkap"
                                                                type="text"
                                                                value="{{ isset($data->nama_lengkap) ? $data->nama_lengkap : '' }}" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="form-control form-control-lg" type="email"
                                                                name="email"
                                                                value="{{ isset($data->email) ? $data->email : '' }}" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Gender</label>
                                                            <div class="d-flex">
                                                                <div class="custom-control custom-radio mb-5 mr-20">
                                                                    <input type="radio" id="customRadio4"
                                                                        name="gender"value="Laki-Laki"
                                                                        class="custom-control-input"
                                                                        {{ $data->gender == 'Laki-Laki' ? 'checked' : '' }} />
                                                                    <label class="custom-control-label weight-400"
                                                                        for="customRadio4">Laki-Laki</label>
                                                                </div>
                                                                <div class="custom-control custom-radio mb-5">
                                                                    <input type="radio" id="customRadio5"
                                                                        name="gender"value="Perempuan"
                                                                        class="custom-control-input"
                                                                        {{ $data->gender == 'Perempuan' ? 'checked' : '' }} />
                                                                    <label class="custom-control-label weight-400"
                                                                        for="customRadio5">Perempuan</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input class="form-control form-control-lg" type="number"
                                                                name="no_telepon"
                                                                value="{{ isset($data->no_telepon) ? $data->no_telepon : '' }}" />
                                                        </div>
                                                    </li>

                                                    {{-- edit alamat --}}
                                                    <li class="weight-500 col-md-6">
                                                        <div class="form-group">
                                                            <label>Provinsi</label>
                                                            <select class="form-control form-control-lg" name="provinsi">
                                                                <option value=""selected>
                                                                    {{ isset($data->provinsi) ? $data->provinsi : 'Provinsi' }}
                                                                </option>
                                                                @if (isset($prov) && $prov != null)
                                                                    <option value="{{ $prov->id }}">
                                                                        {{ $prov->nama }}</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kabupaten</label>
                                                            <select class="form-control form-control-lg" name="kabupaten">
                                                                <option value=""selected>
                                                                    {{ isset($data->kabupaten) ? $data->kabupaten : 'Kabupaten' }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kecamatan</label>
                                                            <select class="form-control form-control-lg" name="kecamatan">
                                                                <option value=""selected>
                                                                    {{ isset($data->kecamatan) ? $data->kecamatan : 'Kecamatan' }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kelurahan</label>
                                                            <select class="form-control form-control-lg" name="kelurahan">
                                                                <option value=""selected>
                                                                    {{ isset($data->kelurahan) ? $data->kelurahan : 'Kelurahan' }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li class="weight-500 col-md-12">
                                                        <div class="form-group">
                                                            <label>Detail Alamat</label>
                                                            <textarea name="detail_alamat" class="form-control">{{ isset($data->detail_alamat) ? $data->detail_alamat : '' }}</textarea>
                                                        </div>
                                                    </li>
                                                    <div class="weight-500 col-md-12 text-center">
                                                        <div class="form-group mb-0">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Information</button>
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
                                                        @if (Auth::user()->role == 1)
                                                            <form
                                                                action="{{ route('kasir.update-password', ['id' => $data->id]) }}"
                                                                method="POST">
                                                            @else
                                                                <form
                                                                    action="{{ route('owner.update-password', ['id' => $data->id]) }}"
                                                                    method="POST">
                                                        @endif
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Password Baru</label>
                                                            <input class="form-control form-control-lg" type="text"
                                                                value="{{ isset($data->email) ? $data->email : '' }}"
                                                                disabled />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Password Baru</label>
                                                            <input class="form-control form-control-lg" name="password"
                                                                type="password" placeholder="Password baru" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Konfirmasi Password</label>
                                                            <input class="form-control form-control-lg"
                                                                name="password_confirmation" type="password"
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
            </div>

            {{-- add footer --}}
            @include('components.footer')
        </div>
    </div>
@endsection
