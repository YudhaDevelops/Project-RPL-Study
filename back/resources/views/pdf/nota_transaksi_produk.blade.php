<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Nota Pembayaran | Zoepy PetShop</title>

    <!-- Favicon -->
    <link rel="icon" href="./images/favicon.png" type="image/x-icon" />
    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        /* .invoice-box table tr.heading td.produk {
            text-align: start;
        }

        .invoice-box table tr.heading td.total {
            text-align: end;
        } */

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
            /* text-align: center; */
        }

        .invoice-box table tr.item td.produk {
            text-align: start;
        }

        /* .invoice-box table tr.item td.jmlh {
            text-align: center;
        } */

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            /* .invoice-box table tr.heading td.produk {
                text-align: start;
            }

            .invoice-box table tr.item td.produk {
                text-align: start;
            } */
        }
    </style>
</head>

<body>
    <div class="invoice-box" id="print-area-2">
        <table>
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://i.ibb.co/DGw0wt6/Logo-Remove-Big.png" alt="Company logo"
                                    style="width: 100%; max-width: 300px" />
                            </td>
                            <td>
                                {{ $id_transaksi }}<br />
                                {{ $tanggal }} <br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                Zoepy PetShop<br />
                                Jl. Kadisoka Jl. Raya Tajem, Tajem, <br>
                                Maguwoharjo, Kec. Depok, <br>
                                Kabupaten Sleman, <br>
                                Daerah Istimewa Yogyakarta 55281<br />
                            </td>

                            <td>
                                Team 7<br />
                                {{ $nama_kasir }}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align: center;">No</td>
                <td style="text-align: left">Item</td>
                <td style="text-align: center">Qntity</td>
                <td>Price</td>
            </tr>
            <?php $i = 1; ?>
            @foreach ($detail as $item)
                <tr class="item">
                    <td style="text-align: center">{{ $i }}</td>
                    <td style="text-align: left">{{ $item->nama_barang }}</td>
                    <td style="text-align: center">{{ $item->jumlah_barang }}</td>
                    <td >@currency($item->harga)</td>
                </tr>
                <?php $i++; ?>
            @endforeach
            <tr class="heading">
                <td></td>
                <td></td>
                <td style="text-align: right">Total:</td>
                <td >@currency($total_harga)</td>
            </tr>

            <tr class="heading">
                <td style="background: #fff; border-bottom: none;"></td>
                <td style="background: #fff; border-bottom: none;"></td>
                <td style="text-align: right">Membayar:</td>
                <td >@currency($user_bayar)</td>
            </tr>
            <tr class=" heading">
                <td style="background: #fff; border-bottom: none;"></td>
                <td style="background: #fff; border-bottom: none;"></td>
                <td style="text-align: right">Kembalian:</td>
                <td >@currency($kembalian)</td>
            </tr>
        </table>
    </div>

</body>

</html>
