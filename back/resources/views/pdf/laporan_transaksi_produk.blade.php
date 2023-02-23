<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Setting CSS bagian header/ kop -->
    <style type="text/css">
        table.page_header {
            width: 1020px;
            border: none;
            background-color: #f19eff;
            border-bottom: solid 1mm #000000;
            padding: 2mm
        }

        table.page_footer {
            width: 1020px;
            border: none;
            background-color: #f19eff;
            border-top: solid 1mm #000000;
            padding: 2mm
        }

        h1 {
            color: #000033
        }

        h2 {
            color: #000055
        }

        h3 {
            color: #000077
        }
    </style>
    <!-- Setting Margin header/ kop -->
    <title>{{ $fileName }}</title>
</head>

<body>
    <page backtop="14mm" backbottom="14mm" backleft="1mm" backright="10mm">
        <page_header>
            <!-- Setting Header -->
            <table class="page_header">
                <tr>
                    <td style="text-align: left; width: 20%">Zoepy Petshop</td>
                    <td style="text-align: center; width: 60%">LAPORAN DATA PENJUALAN PRODUK</td>
                    <td style="text-align: right; width: 20%">
                        {{ $tanggal }}
                    </td>
                </tr>
            </table>
        </page_header>
        <!-- Setting Footer -->
        <page_footer>
            <table class="page_footer">
                <tr>
                    <td style="width: 33%; text-align: left">

                    </td>
                    <td style="width: 34%; text-align: center">
                        Dicetak oleh:
                        {{ auth()->user()->nama_lengkap }}
                    </td>
                    <td style="width: 33%; text-align: right">
                    </td>
                </tr>
            </table>
        </page_footer>
        <!-- Setting CSS Tabel data yang akan ditampilkan -->
        <style type="text/css">
            .tabel2 {
                border-collapse: collapse;
            }

            .tabel2 th,
            .tabel2 td {
                padding: 5px 5px;
                border: 1px solid #000;
            }
        </style>
        <table>
            <tr>
                <th rowspan="3">
                    <img src="https://i.ibb.co/5F7dQWX/Logo-Remove.png"style="width:120px;height:100px" />
                </th>
                <td align="center" style="width: 770px;">
                    <font style="font-size: 18px"><br><b>Zoepy Petshop</b></font>
                    <br><br>
                    Supply & Service Hewan Kesayangan | 
                    <br>
                    Jual Produk Makanan Anjing & Kucing - Grooming Anjing &
                    Kucing
                    <br><br>
                    Krodan, Maguwoharjo, Depok, Sleman, DIY | Telp: (0711) 367769
                </td>
                <th rowspan="3">
                  <img src="https://i.ibb.co/svSdZRx/usd-logo.png"style="width:100px;height:100px" />
              </th>
            </tr>
        </table>
        <hr><br>
        <table class="tabel2">
            <thead>
                <tr>
                    <td style="text-align: center; background: #ddd"><b>No.</b></td>
                    <td style="text-align: center; background: #ddd"><b>Kode Transaksi</b></td>
                    <td style="text-align: center; background: #ddd"><b>Kode Produk</b></td>
                    <td style="text-align: center; background: #ddd"><b>Nama Produk</b></td>
                    <td style="text-align: center; background: #ddd"><b>Jumlah Penjualan</b></td>
                    <td style="text-align: center; background: #ddd"><b>Tanggal Transaksi</b></td>
                    <td style="text-align: center; background: #ddd"><b>Total Penjualan</b></td>
                    <td style="text-align: center; background: #ddd"><b>Nama Kasir</b></td>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($data as $item)
                    <tr>
                        <td style="text-align: center; width:20px;">
                            {{ $i }}
                        </td>
                        <td style="text-align: center; width:90px;">
                              {{ $item->kode_transaksi }}
                        </td>
                        <td style="text-align: center; width:70px;">
                              {{ $item->produk->kode_produk }}
                        </td>
                        <td style="text-align: left; width:150px;">
                              {{ $item->produk->nama_produk }}
                        </td>
                        <td style="text-align: center; width:60px;">
                              {{ $item->jumlah_barang }}
                        </td>
                        <td style="text-align: center; width:150px;">
                              {{ date('d-M-Y', strtotime($item->tanggal_transaksi_produk)) }}
                        </td>
                        <td style="text-align: center; width:150px;">
                              @currency($item->total_harga_produk)
                        </td>
                        <td style="text-align: center; width:200px;">
                              {{ $item->user->nama_lengkap }}
                        </td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            </tbody>
        </table>
    </page>
</body>

</html>
