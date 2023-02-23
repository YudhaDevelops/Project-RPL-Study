<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!--Link css and font style-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('aset/src/styles/style_login.css') }}">
    <title>Login Zoepy Petshop</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="https://i.ibb.co/RNdd4Ss/Logo-Remove.png" />
    <style>
        #tulisan{
            color: #dc1afe;
            text-decoration: none; 
        }
        #tulisan:active , #tulisan:hover{
            color: #7d0093;
        }
        .btn-login{
            background-color: #dc1afe;
        }
        .btn-login:active, .btn-login:hover{
            background-color: #ec7dff;
        }
    </style>
</head>

<body>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

        <div class="container">

            <div class="row">
                <div class="col">
                    <div class="header">
                        <div class="logo">
                            <div class="brand-logo">
                                <a href="{{route('landing')}}"><img class="img-fluid" src="https://i.ibb.co/WnXY3vL/Logo-Remove-Big.png"
                                    alt="logo" id="logo" width="200;"></a>
                            </div>
                          <div class="text-logo">
                            <p>LOVE YOUR PET</p>
                          </div>
                        </div>
                        <div class="breadcrumbs">
                          <div class="bread-home">
                            <a href="{{route('landing')}}"id="tulisan">Home</a>
                          </div>
                          <div class="bread-gambar"></div>
                          <div class="bread-login">
                            <p>Login</p>
                          </div>
                        </div>
            
                        <div class="img-login">
                          <img src="https://i.ibb.co/jgNQB9r/img-login1.png" alt="img-login1" border="0">
                        </div>
                        
                      </div>
                </div>
            </div>

            <!-- Making Form -->
            <div class="row">
                <div class="col-lg-3 offset-lg-1 col-sm-12">
                    <div class="animasi slide-left">
                        <img src="https://i.ibb.co/0fLCDTJ/paws.png" alt="paws" border="0">
                      </div>
                    <div class="card">
                        <h5 class="card-header">LOGIN</h5>
                        <div class="card-body">
                            <form class="form-login" action="{{ route('user.login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="label-form" for="inputEmail1">Email address</label>
                                    <input type="email" name="email" class="form-control" id="inputEmail1"
                                        aria-describedby="emailHelp">
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                                        anyone else.</small>
                                </div>
                                <div class="form-group">
                                    <label class="" for="inputPassword1">Password</label>
                                    <input type="password" name="password" class="form-control" id="inputPassword1">
                                    <a href="{{route('user.forget-password')}}">
                                        <small id="forgot-help" class="form-text text-muted" style="text-align: right">
                                            Forgot Password
                                        </small>
                                    </a>
                                </div>
                                <button type="submit" class="btn-login">Login</button>
                            </form>
                        </div>   
                    </div>
                                       
                    <div class="animasi2 slide-left">
                        <img src="https://i.ibb.co/0fLCDTJ/paws.png" alt="paws" border="0">
                    </div>
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
</body>

</html>
