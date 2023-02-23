<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://i.ibb.co/RNdd4Ss/Logo-Remove.png" />
    <link rel="stylesheet" href="{{ asset('aset/landing/css/bootstrap.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Zoepy Petshop | Ganti Password</title>
    <style>
        body {
            background: #f9d7ff;
        }

        #tombol {
            background-color: #dc1afe;
            color: white;
        }

        #tombol:active,
        #tombol:hover {
            background-color: #ea72ff;
            color: white;
        }

        #logo {
            width: 10vw;
        }

        @media (max-width: 426px) {
            #logo {
                width: 20vw;
            }

            .btn {
                width: 40px;
                height: 20px;
                font-size: 10px;
                padding-top: 0px;
                padding-left: 7px;
            }
        }

        @media (max-width: 769px) {
            #logo {
                width: 20vw;
            }

            .btn {
                width: 70px;
                height: 30px;
                font-size: 15px;
                padding-top: 2px;
                padding-left: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="col-md-6 offset-md-3 pb-5 pt-2">
      <a href="{{route('landing')}}">
            <img class="img-fluid" src="https://i.ibb.co/WnXY3vL/Logo-Remove-Big.png" alt="logo" id="logo">
      </a>
    </div>
    <div class="col-md-6 offset-md-3 pt-md-5 pb-5">
        <div class="card" style="background-color: #fdf4ff;">
            <div class="card-header">
                <h3 class="mb-0">Ganti Password</h3>
            </div>
            <div class="card-body">
                <form class="form" role="form" autocomplete="off" action="{{ route('send.ganti-password') }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Anda</label>
                        <input name="email" value="{{ isset($user->email) ? $user->email : '' }}" type="email"
                            class="form-control" id="email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordOld">Password Lama</label>
                        <input name="password" type="password" class="form-control" id="inputPasswordOld"
                            required="">
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordNew">Password Baru</label>
                        <input name="pass_baru" type="password" class="form-control" id="inputPasswordNew"
                            required="">
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordNewVerify">Masukan Lagi Password Baru</label>
                        <input name="pass_baru_confirmation" type="password" class="form-control"
                            id="inputPasswordNewVerify" required="">
                    </div>
                    <div class="form-group">
                        <a href="{{route('landing')}}" type="button" class="btn btn-secondary btn-lg float-right ml-3">Back</a>
                        <button type="submit" class="btn btn-light btn-lg float-right" id="tombol">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
