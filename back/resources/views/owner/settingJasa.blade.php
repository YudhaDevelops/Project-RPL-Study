@extends('layouts.master', ['set_jasa' => 'active', 'title' => 'Setiing Jasa | '])
@section('head')
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/src/plugins/cropperjs/dist/cropper.css') }}" />
@stop

@section('jsFooter')
    <script src="{{ asset('aset/vendors/scripts/datatable-setting.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/cropperjs/dist/cropper.js') }}"></script>
    <script src="{{ asset('aset/proses/owner.js') }}"></script>
    <script>
        var $modal = $('#modal_image');
        var image = document.getElementById('image_modal');
        let id_jasa;
        var cropper;

        $("body").on("change", "#gambar_jasa_update", function(e) {
            id_jasa = $(this).data('id');
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
            $('#gambar_jasa_update').val('');
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
                        url: "update-foto-jasa",
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data,
                            'id_jasa': id_jasa,
                        },
                        success: function(data) {
                            $modal.modal('hide');
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
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Halaman Setting Data Jasa</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Data Jasa
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
                                <h4 class="text-black h4">Data Jasa</h4>
                            </div>
                        </div>
                    </div>
                    <div class="pb-20">
                        <div class="container-fluid">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th class="table-plus">#</th>
                                        <th>Nama Jasa</th>
                                        <th>Harga Jasa</th>
                                        <th>Gambar Jasa</th>
                                        <th class="datatable-nosort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data) && $data != null)
                                        <?php $i = 1; ?>
                                        @foreach ($data as $p)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $p->nama_jasa }}</td>
                                                <td>{{ $p->harga_jasa }}</td>
                                                <td><img src="{{ isset($p->gambar_jasa) ? $p->gambar_jasa : 'Belum Diset' }}"
                                                        width="50px" alt="gambar"></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                            href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div
                                                            class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#show_modal_jasa{{ $p->id }}">
                                                                <i class="dw dw-eye"></i> View</button>
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#edit_modal_jasa{{ $p->id }}">
                                                                <i class="dw dw-edit2"></i> Edit</button>
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
            <!-- modal show data -->
            @include('modals.jasa.show_data_jasa')
            <!-- modal edit data -->
            @include('modals.jasa.edit_data_jasa')
        </div>
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

@endsection
