<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!--Link css and font style-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('aset/src/styles/style_detailInfoPet.css')}}">
    <link rel="icon" href="https://i.ibb.co/5F7dQWX/Logo-Remove.png" />
    <title>Info Pet</title>
</head>

<body>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

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
                                <a href="{{route('landing')}}">Home</a>
                            </div>
                            <div class="bread-gambar"></div>
                            <div class="bread-info">
                                <a href="{{route('guest.infoPet')}}">Info Pet</a>
                            </div>
                            <div class="bread-gambar-2"></div>
                            <div class="bread-info-detail">
                                <p>Detail Info Pet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="info-hewan-tab" data-toggle="tab" href="#info-hewan" role="tab"
                        aria-controls="info-hewan" aria-selected="true">Info Hewan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="proses-tab" data-toggle="tab" href="#proses" role="tab"
                        aria-controls="profile" aria-selected="false">Proses</a>
                </li>
            </ul>

            <div class="tab-content justify-content-center">
                <div class="tab-pane active" id="info-hewan" role="tabpanel" aria-labelledby="info-hewan-tab">
                    <div class="col-12 mt-4 justify-content-center">
                        <div class="card">
                            <h6 class="kode-jasa">JASA Grooming</h6>
                            <img class="img-info"
                                src="{{isset($gambar) ? $gambar : 'https://i.ibb.co/W5KBCtg/106686172-1598966433320-gettyimages-1152439648-istockalypse-home-office-00062.jpg'}}"
                                style="width: 40%;">
                            <table class="table table-hover">
                                <tr>
                                    <td>Nama Hewan</td>
                                    <td>:</td>
                                    <td>{{isset($data->nama_hewan) ? $data->nama_hewan : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Pemilik</td>
                                    <td>:</td>
                                    <td>{{isset($data->pemilik) ? $data->pemilik : ''}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="proses" role="tabpanel" aria-labelledby="proses-tab">
                    <div class="col-12 mt-4 justify-content-center">
                        <div class="card">
                            <h6 class="kode-jasa">KODE JASA</h6>
                            <table class="table table-hover">
                                <tr>
                                    <td>Jenis Jasa</td>
                                    <td>:</td>
                                    <td>{{isset($data->nama_jasa) ? $data->nama_jasa : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Proses</td>
                                    <td>:</td>
                                    <td>{{isset($data->tahapan) ? $data->tahapan : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Jam Masuk</td>
                                    <td>:</td>
                                    <td>{{date('H:i', strtotime($data->waktu_masuk))}}</td>
                                </tr>
                                <tr>
                                    <td>Di perkirakan selesai jam</td>
                                    <td>:</td>
                                    <td>{{date('H:i', strtotime($data->waktu_keluar))}}</td>
                                </tr>
                                <tr>
                                    <td>Total biaya</td>
                                    <td>:</td>
                                    <td>@currency($data->harga_jasa)</td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        <button class="btn btn-outline-primary"
                                        @if (isset($data->tahapan) && $data->tahapan != "Selesai")
                                            disabled    
                                        @endif>
                                            Cetak Nota
                                        </button>
                                    </td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <img src="https://i.ibb.co/4gqB3QH/Cats-Brit-removebg-preview.png" alt="Cats-Brit-removebg-preview"
                border="0" class="img-att-2 rotateimgright">

            <script>
                $(function() {
                    $('#myTab li:first-child a').tab('show')
                })
            </script>

        </div>

    </div>
</body>

</html>
