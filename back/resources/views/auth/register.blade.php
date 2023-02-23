<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('aset/src/styles/style_register.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Register Zoepy Petshop</title>
</head>

<body>
    <div class="container-fluid">
        <div class="container">

            <div class="row">
                <div class="col">

                    <div class="header">
                        <div class="logo">
                            <div class="gambar-logo"></div>
                            <div class="text-logo">
                                <p>LOVE YOUR PET</p>
                            </div>
                        </div>
                        <div class="breadcrumbs">
                            <div class="bread-home">
                                <a href="LandingAwal.html">Home</a>
                            </div>
                            <div class="bread-gambar"></div>
                            <div class="bread-login">
                                <p>Register</p>
                            </div>
                        </div>

                        <div class="img-login">
                            <img src="https://i.ibb.co/xFW9N0R/img-login1.png" alt="">
                        </div>

                    </div>
                </div>

            </div>


            <div class="row">
                <div class="col-lg-3 offset-lg-1 col-sm-12">
                    <div class="card">
                        <h5 class="card-header">Register</h5>
                        <div class="card-body">
                            <form class="form-register" action="{{route('user.register')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="label-form" for="inputNama">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" id="inputNama">
                                </div>

                                <div class="form-group">
                                    <label class="label-form" for="inputEmail">Email address</label>
                                    <input type="email" class="form-control" name="email" id="inputEmail1">
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderRadio1"
                                      value="Laki-laki">
                                    <label class="form-check-label" for="genderRadio1">
                                        Laki-laki
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderRadio2"
                                    value="Perempuan">
                                    <label class="form-check-label" for="genderRadio2">
                                        Perempuan
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="label-form" for="inputNoTelp">No Telp.</label>
                                    <input type="text" class="form-control" name="no_telepon" id="inputNoTelp">
                                </div>

                                <div class="form-group">
                                    <label class="" for="inputPassword1">Password</label>
                                    <input type="password" class="form-control" name="password" id="inputPassword1">
                                </div>

                                <div class="form-group">
                                    <label class="label-form" for="provinsi">Provinsi</label>
                                    <select class="provinsi-select form-control col-12" name="provinsi" id="provinsi">
                                        <option value="#" disabled selected>Pilih Provinsi</option>
                                        @if (isset($prov) && $prov != null)
                                            <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="label-form" for="kabupaten">Kabupaten</label>
                                    <select class="provinsi-select form-control col-12" name="kabupaten" id="kabupaten">
                                        <option value="#" disabled selected>Pilih Kabupaten</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="label-form" for="kecamatan">Kecamatan</label>
                                    <select class="provinsi-select form-control col-12" name="kecamatan" id="kecamatan">
                                        <option value="#" disabled selected>Pilih Kecamatan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="label-form" for="kelurahan">Kelurahan</label>
                                    <select class="provinsi-select form-control col-12" name="kelurahan"
                                        id="kelurahan">
                                        <option value="#" disabled selected>Pilih Kelurahan</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="detailAlamat">Detail Alamat</label>
                                    <textarea class="form-control" id="detailAlamat" name="detail_alamat" rows="3"></textarea>
                                </div>


                                <button type="submit" class="btn-register">Register Akun</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="{{ asset('aset/proses/register.js') }}"></script>

    
    {{-- js --}}
    <script>
      @if (session()->has('success'))
          Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: `{{ session()->get('success') }}`,
              showConfirmButton: false,
              timer: 3000
          });
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
              title: '{{ session()->get('errors')->first() }}'
          })
      @endif
  </script>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>
