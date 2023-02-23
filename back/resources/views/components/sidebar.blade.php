<div class="left-side-bar">
    <div class="brand-logo">
        <!-- <p width="100%" class="text-center ml-2  pt-20">Petshop</p> -->
        <a href="{{ route('landing') }}">
            <img src="{{ asset('aset/src/images/logo-ds.png') }}" alt="" class="light-logo pl-2 text-center" />
            <!-- <img src="vendors/images/deskapp-logo-white.svg" alt="" class="light-logo" /> -->
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('kasir.index') }}"
                        class="dropdown-toggle no-arrow {{ isset($dashboard) ? $dashboard : '' }}">
                        <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <br><br>
                @if (Auth::user()->role == 1)
                    <li>
                        <div class="sidebar-small-cap">SALE PRODUK</div>
                    </li>
                    <li>
                        <a href="{{ route('kasir.jual-produk') }}"
                            class="dropdown-toggle no-arrow {{ isset($penjualan) ? $penjualan : '' }}">
                            <span class="micon icon-copy fa fa-shopping-basket"></span>
                            <span class="mtext" width="10">
                                New Sale Produk
                            </span>
                        </a>
                    </li>
                    <br><br>
                    <li>
                        <div class="sidebar-small-cap">SALE JASA</div>
                    </li>
                    <li>
                        <a href="{{route('jasa.grooming.penitipan')}}" class="dropdown-toggle no-arrow  {{isset($grooming_penitipan) ? $grooming_penitipan : ''}}">
                            <span class="micon">
                                <img class="" src="{{ asset('aset/icon/icon-sale.svg') }}" width="30"
                                    alt="">
                            </span>
                            <span class="mtext" width="10">
                                New Jasa Service
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jasa.transaksi-jasa') }}"
                            class="dropdown-toggle no-arrow 
                        {{ isset($transaksi_jasa) ? $transaksi_jasa : '' }}">
                            <i class="micon icon-copy fa fa-dollar" aria-hidden="true"></i>
                            <span class="mtext" width="10">
                                Pembayaran Jasa
                            </span>
                        </a>
                    </li>
                    <br><br>
                    <li>
                        <div class="sidebar-small-cap">MASTER</div>
                    </li>
                    <li>
                        <a href="{{ route('produk.anjing') }}"
                            class="dropdown-toggle no-arrow {{ isset($produk_anjing) ? $produk_anjing : '' }}">
                            <span class="micon">
                                <img class="" src="{{ asset('aset/icon/dog-bowl-icon.svg') }}" width="30"
                                    alt="">
                            </span>
                            <span class="mtext" width="10">
                                Makanan Anjing
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('produk.kucing') }}"
                            class="dropdown-toggle no-arrow {{ isset($produk_kucing) ? $produk_kucing : '' }}">
                            <span class="micon">
                                <img class="" src="{{ asset('aset/icon/cat-food-icon.svg') }}" width="30"
                                    alt="">
                            </span>
                            <span class="mtext" width="10">
                                Makanan Kucing
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jasa.grooming') }}"
                            class="dropdown-toggle no-arrow {{ isset($grooming) ? $grooming : '' }}">
                            <span class="micon">
                                <img class="" src="{{ asset('aset/icon/salon.svg') }}" width="30"
                                    alt="">
                            </span>
                            <span class="mtext" width="10">
                                Grooming
                            </span>
                        </a>
                    <li>
                        <a href="{{ route('jasa.penitipan') }}"
                            class="dropdown-toggle no-arrow {{ isset($penitipan) ? $penitipan : '' }}">
                            <span class="micon">
                                <img class="" src="{{ asset('aset/icon/pet-salon.svg') }}" width="30"
                                    alt="">
                            </span>
                            <span class="mtext" width="10">
                                Penitipan
                            </span>
                        </a>
                    </li>
                    <br><br>
                    <li>
                        <div class="sidebar-small-cap">CUSTOMER</div>
                    </li>
                    <li>
                        <a href="{{ route('kasir.customer') }}"
                            class="dropdown-toggle no-arrow {{ isset($customer) ? $customer : '' }}">
                            <span class="micon">
                                <img class="" src="{{ asset('aset/icon/pet-people.svg') }}" width="30"
                                    alt="">
                            </span>
                            <span class="mtext" width="10">
                                Customer
                            </span>
                        </a>
                    </li>
                    <br><br>
                @endif
                @if (Auth::user()->role == 2)
                    <li>
                        <div class="sidebar-small-cap">REPORT</div>
                    </li>
                    <li>
                        <a href="{{ route('owner.laporan-penjualan') }}"
                            class="dropdown-toggle no-arrow {{ isset($laporan_penjualan) ? $laporan_penjualan : '' }}">
                            <span class="micon icon-copy bi bi-filetype-pdf"></span><span class="mtext">Laporan Penjualan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('owner.laporan-jasa')}}"
                            class="dropdown-toggle no-arrow {{ isset($laporan_jasa) ? $laporan_jasa : '' }}">
                            <span class="micon icon-copy bi bi-filetype-pdf"></span><span class="mtext">Laporan Jasa</span>
                        </a>
                    </li>
                    <br><br>
                @endif
                <li>
                    <div class="sidebar-small-cap">SISTEM</div>
                </li>
                @if (Auth::user()->role == 2)
                    <li>
                        <a href="{{ route('owner.account-kasir') }}"
                            class="dropdown-toggle no-arrow {{ isset($dataKasir) ? $dataKasir : '' }}">
                            <span class="micon icon-copy fa fa-users"></span><span class="mtext">Users</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->role == 1)
                    <li>
                        <a href="{{ route('kasir.settingProfile') }}"
                            class="dropdown-toggle no-arrow {{ isset($profile) ? $profile : '' }}">
                            <span class="micon icon-copy fa fa-gears"></span>
                            <span class="mtext">Profile</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('owner.setting-jasa') }}"
                            class="dropdown-toggle no-arrow {{ isset($set_jasa) ? $set_jasa : '' }}">
                            <span class="micon icon-copy bi bi-gear-fill"></span><span class="mtext">Setting
                                Jasa</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('owner.settingProfile') }}"
                            class="dropdown-toggle no-arrow {{ isset($profile) ? $profile : '' }}">
                            <span class="micon icon-copy fa fa-gears"></span><span class="mtext">Profile</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
