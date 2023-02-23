<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://i.ibb.co/RNdd4Ss/Logo-Remove.png" />
    <link rel="stylesheet" href="{{ asset('aset/landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('aset/landing/css/W2_TampilProduk.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Zoepy Petshop</title>

    <script>
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;

                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                } else {
                    reveals[i].classList.remove("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
    </script>
</head>

<body>
    <form action="" method="GET">
        <nav class="navbar fixed-top justify-content-between" id="navbar">
            <div class="row">
                <div class="col-3">
                    <a href="{{ route('landing') }}"><img class="img-fluid"
                            src="https://i.ibb.co/WnXY3vL/Logo-Remove-Big.png" alt="logo" id="logo"></a>
                </div>
                <div class="col-6 form-inline" id="scbox">
                    <div class="input-group mb-3" id="boxx">
                        <input type="text" class="form-control" name="key" value="{{isset($_GET['key']) ? $_GET['key'] : ''}}"
                            placeholder="Cari Produk" aria-label="Cari Produk" aria-describedby="basic-addon2"
                            id="boxxes">
                        <div class="input-group-append" id="car">
                            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit"
                                id="cari">Cari</button>
                        </div>
                    </div>
                </div>
                <div class="col-1" id="scbox">
                    <div class="fs-2">
                        <a href="{{ route('landing') }}"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="bi bi-house-door-fill" viewBox="0 0 16 16" id="kembali">
                                <path
                                    d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="bg"></div>
        <div class="bg bg2"></div>
        <div class="bg bg3"></div>
        <div class="container-fluid" id="atas"></div>

        <div class="container-fluid" id="contFilter">
            <div class="row" id="filter">
                <div class="col-3" id="filter">
                    <h5>Urutkan: </h5>
                </div>
                <div class="col-2">
                    <select name="filter" id="tombol" class="btn-outline-dark">
                        <option value="" selected>Pilih</option>
                        <option value="terbaru" @if(isset($_GET['filter']) != null && $_GET['filter'] == "terbaru") selected @endif>Produk Terbaru</option>
                        <option value="terlaris" @if(isset($_GET['filter']) != null && $_GET['filter'] == "terlaris") selected @endif>Produk Terlaris</option>
                        <option value="rendah_tinggi" @if(isset($_GET['filter']) != null && $_GET['filter'] == "rendah_tinggi") selected @endif>Harga Rendah Ke Tinggi</option>
                        <option value="tinggi_rendah" @if(isset($_GET['filter']) != null && $_GET['filter'] == "tinggi_rendah") selected @endif>Harga Tinggi ke Rendah</option>
                        <option value="asc_name" @if(isset($_GET['filter']) != null && $_GET['filter'] == "asc_name") selected @endif>Nama Produk A-Z</option>
                        <option value="desc_name" @if(isset($_GET['filter']) != null && $_GET['filter'] == "desc_name") selected @endif>Nama Produk Z-A</option>
                    </select>
                </div>
                <div class="col-2">
                </div>
                <div class="col-2">
                    <div class="dropdown">
                    </div>
                </div>
                <div class="col-2">
                    <div class="dropdown">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="container-fluid" id="batas"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                <h1>Produk</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="produk">
        <div class="container xl">
            <div class="row">
                @if (isset($produk) && $produk != null)
                    @foreach ($produk as $item)
                        <div class="col-sm-3 reveal">
                            <div class="card xs xl" data-toggle="modal" data-target="#modal2" id="proct">
                                <img src="{{ isset($item->gambar_produk) ? $item->gambar_produk : 'https://images.tokopedia.net/img/cache/500-square/VqbcmM/2022/8/3/a66a35f5-7aa1-4cdf-bcd8-4c76567110c3.jpg' }}"
                                    class="card-img-top" alt="g1">
                                <div class="card-block">
                                    <b>
                                        <p class="card-text text-center">
                                            {{ isset($item->nama_produk) ? $item->nama_produk : '' }}</p>
                                    </b>
                                    <p class="card-text">@currency($item->harga)-,</p>
                                    <p class="card-text">Stok : {{ isset($item->stok) ? $item->stok : '0' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col text-center">
                        Produk Tidak Ditemukan Silahkan Cari Dengan Kata Kunci Lainnya
                    </div>
                @endif
            </div>
        </div>
        
        @if(isset($_GET['filter']) && $_GET['filter'] != "terlaris" && $produk != null)
        <nav data-pagination>
            <div class="pagination d-flex justify-content-center" id="page">
                {!! $produk->links() !!}
            </div>
        </nav>
        @endif
        <br>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light pt-5 mt-5 py-5" id="navbar">
        <a href="{{ route('landing') }}"><img class="img-fluid" src="https://i.ibb.co/RNdd4Ss/Logo-Remove.png"
                alt="g2" id="logobawah"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2"
            aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent2">
            <ul class="navbar-nav ml-auto text-right">
                <li class="nav-item active p-3">
                    <h5>Alamat : </h5>
                    <p>Krodan, Maguwoharjo, Depok, Sleman, DIY</p>
                </li>
                <li class="nav-item active p-3">
                    <h5>No Telpon : </h5>
                    <p>081234567890</p>
                </li>
                <li class="nav-item active p-3">
                    <h5>Email : </h5>
                    <p>ZoepyPetshop@gmail.com</p>
                </li>
                <li class="nav-item active p-3">
                    <h5>Ikuti Kami : </h5>
                    <a href="https://goo.gl/maps/QfhQkWiGu1kd9RJC6"><i class="fa fa-2x fa-map-marker"></i></a>&emsp;
                    <a href="https://www.facebook.com/zoepy.petshop"><i class="fa fa-2x fa-facebook"></i></a>&emsp;
                    <a href="https://www.instagram.com/zoepypetshop/?hl=id"><i class="fa fa-2x fa-instagram"></i></a>
                </li>
            </ul>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" />
    </script>
    <script>
        var btn = document.getElementById('cari');

        $("[name=filter]").on("change", (e) => {
            btn.click();
        });
    </script>
</body>

</html>
