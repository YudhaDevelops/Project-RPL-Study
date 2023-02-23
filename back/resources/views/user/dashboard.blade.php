@extends('layouts.master', ['dashboard' => 'active', 'title' => 'Dashboard Kasir | '])
@section('css')
@endsection

@section('jsHead')
@endsection

@section('jsFooter')
    <script src="{{ asset('aset/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('aset/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('aset/vendors/scripts/dashboard3.js') }}"></script>
    <script type="text/javascript">
        var harian = <?php echo json_encode($hari); ?>;
        var jasaHarian = <?php echo json_encode($titipHarian); ?>;
        var phpJual = <?php echo json_encode($jualHarian); ?>;

        var jualBulanan = <?php echo json_encode($jualBulan); ?>;
        var jasaBulanan = <?php echo json_encode($titipBulan); ?>;
        var bulan = <?php echo json_encode($bulan); ?>;

        // harian
        var options1 = {
            series: [{
                    name: "Total Produk Terjual",
                    data: phpJual
                },
                {
                    name: "Total Transaksi Jasa",
                    data: jasaHarian
                }
            ],
            chart: {
                height: 300,
                type: 'line',
                zoom: {
                    enabled: false,
                },
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 16,
                    opacity: 0.2
                },
                toolbar: {
                    show: false
                }
            },
            colors: ['#f0746c', '#255cd3'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: [3, 3],
                curve: 'smooth'
            },
            grid: {
                show: false,
            },
            markers: {
                colors: ['#f0746c', '#255cd3'],
                size: 5,
                strokeColors: '#ffffff',
                strokeWidth: 2,
                hover: {
                    sizeOffset: 2
                }
            },
            xaxis: {
                categories: harian,
                labels: {
                    style: {
                        colors: '#8c9094'
                    }
                }
            },
            yaxis: {
                min: 0,
                max: 50,
                labels: {
                    style: {
                        colors: '#8c9094'
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: 0,
                labels: {
                    useSeriesColors: true
                },
                markers: {
                    width: 10,
                    height: 10,
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#activities-chart"), options1);
        chart.render();

        $('document').ready(function() {
            $("[name=pilihan_chart]").on("change", (e) => {
                let selectChart = e.target.value;

                if (selectChart == "minggu") {
                    const intJual = phpJual.map(Number);
                    const maxJual = Math.max.apply(Math, intJual);
                    const maxJasa = Math.max.apply(Math, jasaHarian);
                    const max = Math.max(maxJual, maxJasa);
                    chart.updateSeries([{
                            name: "Total Produk Terjual",
                            data: intJual,
                        },
                        {
                            name: "Total Transaksi Jasa",
                            data: jasaHarian,
                        }
                    ]);
                    chart.updateOptions({
                        xaxis: {
                            categories: harian,
                        }
                    });
                    chart.updateOptions({
                        yaxis: {
                            min: 0,
                            max: max + 10,
                        }
                    })
                } else if (selectChart == "tahun") {
                    const intJual = jualBulanan.map(Number);
                    const maxJual = Math.max.apply(Math, intJual);
                    const maxJasa = Math.max.apply(Math, jasaBulanan);
                    const max = Math.max(maxJual, maxJasa);
                    chart.updateSeries([{
                            name: "Total Produk Terjual",
                            data: intJual,
                        },
                        {
                            name: "Total Transaksi Jasa",
                            data: jasaBulanan,
                        }
                    ]);
                    chart.updateOptions({
                        xaxis: {
                            categories: bulan,
                        }
                    });
                    chart.updateOptions({
                        yaxis: {
                            min: 0,
                            max: max + 10,
                        }
                    })
                }
            });

        })
    </script>
@endsection

@section('content')
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="title pb-20">
                <h2 class="h3 mb-0">Dashboard</h2>
            </div>

            <div class="row pb-10">
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $jumlahAnjing }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Produk Makanan Anjing
                                </div>
                            </div>
                            <div class="widget-icon" style="background-color: rgb(190, 190, 190);">
                                <div class="icon" data-color="#ff5b5b">
                                    <!-- <i class="icon-copy dw dw-calendar1"></i> -->
                                    <img class="icon" src="{{ asset('aset/icon/dog-bowl-icon.svg') }}" width="35"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $jumlahKucing }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Produk Makanan Kucing
                                </div>
                            </div>
                            <div class="widget-icon" style="background-color: rgb(190, 190, 190);">
                                <div class="icon" data-color="#ff5b5b">
                                    <!-- <span class="icon-copy ti-heart"></span> -->
                                    <img class="icon" src="{{ asset('aset/icon/cat-food-icon.svg') }}" width="35"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ $jumlahCustomer }}</div>
                                <div class="font-14 text-secondary weight-500">
                                    Total Customer
                                </div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon">
                                    <i class="icon-copy fa fa-users" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                    <div class="card-box height-100-p widget-style3">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">@currency($totalPenjualan)</div>
                                <div class="font-14 text-secondary weight-500">Total Penjualan</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#09cc06">
                                    <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pb-10">
                <div class="col-md-12 mb-20">
                    <div class="card-box height-100-p pd-20">
                        <div
                            class="d-flex flex-wrap justify-content-between align-items-center pb-0
                            pb-md-3">
                            <div class="h5 mb-md-0">Laporan Penjualan</div>
                            <div class="form-group mb-md-0">
                                <select class="form-control form-control-sm selectpicker" name="pilihan_chart">
                                    <option value="minggu">Last Week</option>
                                    <option value="tahun">Last 12 Month</option>
                                </select>
                            </div>
                        </div>
                        <div id="activities-chart"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box pb-10">
                        <div class="h5 pd-20 mb-0">Produk Terlaris</div>
                        <div class="container-fluid">
                            <table class="pd-1 data-table hover table nowrap ">
                                <thead>
                                    <tr>
                                        <th class="table-plus">#</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Produk</th>
                                        <th>Bobot</th>
                                        <th>Total Terjual</th>
                                        <th>Stok</th>
                                        <th>Gambar Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($laris) && $laris != null)
                                        <?php $i = 1; ?>
                                        @foreach ($laris as $p)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $p->nama_produk }}</td>
                                                <td>@currency($p->harga_produk)</td>
                                                <td>{{ $p->bobot }} gram</td>
                                                <td>{{ $p->total_produk_terlaris }}</td>
                                                <td>{{ $p->stok }}</td>
                                                <td class="table-plus">
                                                    <div class="name-avatar d-flex align-items-center">
                                                        <div class="avatar mr-2 flex-shrink-0">
                                                            @if ($p->gambar_produk != null)
                                                                <img src="{{ isset($p->gambar_produk) ? $p->gambar_produk : '' }}"
                                                                    class="border-radius-5 shadow" width="60"
                                                                    height="60" alt="" />
                                                            @else
                                                                Belum Diset
                                                            @endif
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
            </div>

            <br>
            <div class="title pb-20 pt-20">
                <h2 class="h3 mb-0">Status Order</h2>
            </div>

            <div class="row">
                @if (isset($groom) && $groom != null)
                    @foreach ($groom as $g)
                        <div class="col-md-4 mb-20">
                            <a href="{{ route('jasa.grooming') }}" class="card-box d-block mx-auto pd-20 text-secondary">
                                <div class="img pb-30">
                                    <img src="https://cdnwpedutorepartner.gramedia.net/wp-content/uploads/2020/05/19155837/Profesi-Pet-Salon-Grooming_626-x-626-px.png"
                                        alt="" />
                                </div>
                                <div class="content">
                                    <h3 class="h4">{{ $g->nama_jasa }}</h3>
                                    <p class="max-width-500">
                                        Nama Hewan : {{ $g->nama_hewan }}<br>
                                        Tahapan : {{ $g->tahapan }}<br>
                                        Tanggal Grooming : {{ date('d M Y', strtotime($g->tanggal_grooming)) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
                @if (isset($titip) && $titip != null)
                    @foreach ($titip as $t)
                        <div class="col-md-4 mb-20">
                            <a href="{{ route('jasa.penitipan') }}" class="card-box d-block mx-auto pd-20 text-secondary">
                                <div class="img pb-30">
                                    <img src="https://qph.cf2.quoracdn.net/main-qimg-5182bb69c6d8b7aa6eb68cbc756bc049-pjlq"
                                        alt="" />
                                </div>
                                <div class="content">
                                    <h3 class="h4">Penitipan (No {{ $t->no_kandang }})</h3>
                                    <p class="max-width-500">
                                        Nama Hewan : {{ $t->nama_hewan }}<br>
                                        Tanggal Masuk : {{ date('d M Y', strtotime($t->tanggal_masuk)) }}<br>
                                        Tanggal Keluar : {{ date('d M Y', strtotime($t->tanggal_keluar)) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
                @if ($titip == null && $groom == null)
                <div class="col-md-4 mb-20">
                    <a class="card-box d-block mx-auto pd-20 text-secondary">
                        <div class="content">
                            <h3 class="h4">Tidak Ada Jasa Yang Sedang DI Pesan</h3>
                            <p class="max-width-500">
                                
                            </p>
                        </div>
                    </a>
                </div>
                @endif
            </div>
            @include('components.footer')
        </div>
    </div>
@endsection
