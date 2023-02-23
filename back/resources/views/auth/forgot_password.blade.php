<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('aset/vendors/styles/style.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #login{
            background-color: white ;
            color: #dc1afe;
            border-color: #dc1afe;
        }
        #login:hover, #login:active{
            background-color: #dc1afe ;
            color: white;
            border-color: white;
        }
        #submit{
            background-color: #dc1afe;
            color: white;
        }
        #submit:hover, #submit:active{
            background-color: #ec7dff;
        }
        #tulisan{
            color: #dc1afe;
        }
    </style>
</head>

<body>
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="{{route('login')}}">
                    <img src="{{ asset('aset/src/images/logo-ds.png') }}" alt="" />
                    {{-- <img src="vendors/images/deskapp-logo.svg" alt="" /> --}}
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <li><a href="{{route('login')}}" id="tulisan">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    {{-- <img src="vendors/images/forgot-password.png" alt="" /> --}}
                    <img src="https://i.ibb.co/z8d1Mdn/reset-pass.png" alt="reset-pass">
                </div>
                <div class="col-md-6">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center" id="tulisan">Lupa Password</h2>
                        </div>
                        <h6 class="mb-20">
                            Masukkan Email Anda Untuk Reset Password Anda
                        </h6>
                        <form action="{{route('user.send-email')}}" method="POST">
                            @csrf
                            <div class="input-group custom">
                                <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="fa fa-envelope-o"
                                            aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-5">
                                    <div class="input-group mb-0">
                                        {{-- use code for form submit --}}
                                        <input class="btn btn-light btn-lg btn-block" type="submit" value="Submit" id="submit">
                                        {{-- <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button> --}}
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="font-16 weight-600 text-center" data-color="#707373">
                                        OR
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group mb-0">
                                        <a class="btn btn-lg btn-block"
                                            href="{{ route('login') }}" id="login">Login</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="{{ asset('aset/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('aset/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('aset/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('aset/vendors/scripts/layout-settings.js') }}"></script>
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
                title: '{{ session()->get('success') }}'
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
                title: '{{ session()->get('errors')->first() }}'
            })
        @endif
    </script>
</body>

</html>
