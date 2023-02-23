<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{$title}} Zoepy Petshop</title>
	<!-- Site favicon -->
	{{-- <link rel="apple-touch-icon" sizes="180x180" href="{{asset('aset/vendors/images/apple-touch-icon.png')}}" />
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('aset/vendors/images/favicon-32x32.png')}}" />
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('aset/vendors/images/favicon-16x16.png')}}" /> --}}
	
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('aset/vendors/styles/core.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('aset/vendors/styles/icon-font.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('aset/src/plugins/datatables/css/dataTables.bootstrap4.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('aset/src/plugins/datatables/css/responsive.bootstrap4.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('aset/vendors/styles/style.css')}}" />

	{{-- js in head --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	@yield('head')
</head>
<body>
    <!-- preloading -->
	<!-- <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="{{asset('aset/vendors/images/deskapp-logo.svg')}}" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div> -->

    <!-- header -->
	@include('components.header')

    <!-- sidebar -->
	@include('components.sidebar')
	<div class="mobile-menu-overlay"></div>

    <!-- contents -->
    @yield('content')

	<!-- js -->
	<script src="{{asset('aset/vendors/scripts/core.js')}}"></script>
	<script src="{{asset('aset/vendors/scripts/script.min.js')}}"></script>
	<script src="{{asset('aset/vendors/scripts/process.js')}}"></script>
    <script src="{{asset('aset/src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('aset/src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('aset/src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('aset/src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
	{{-- alert js --}}
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
    </script>
	@yield('jsFooter')
	</body>
</html>