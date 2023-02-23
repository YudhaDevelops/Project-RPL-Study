<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list"></div>
        <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
        <div class="header-search">
        </div>
    </div>
    <div class="header-right">
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        {{-- <img src="https://i.ibb.co/6RXKvM5/img.jpg" alt="img" border="0"> --}}
                        @if (isset(Auth::user()->foto_profile))
                            <img src="{{ asset('profile/'.Auth::user()->foto_profile) }}" alt="">
                            {{-- <img src="@fotoProfile(auth()->user()->id)" alt=""> --}}
                        @else
                        <img src="https://i.ibb.co/6RXKvM5/img.jpg" alt="" />
                        @endif
                    </span>
                    <span class="user-name">{{ isset(Auth::user()->nama_lengkap) ? Auth::user()->nama_lengkap : 'Admin' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    @if (Auth::user()->role == 1)
                    <a class="dropdown-item" href="{{route('kasir.settingProfile')}}">
                        <i class="dw dw-user1"></i>
                        Profile
                    </a>
                    @else
                    <a class="dropdown-item" href="{{route('owner.settingProfile')}}">
                        <i class="dw dw-user1"></i>
                        Profile
                    </a>
                    @endif
                    <a class="dropdown-item" href="{{route('user.logout')}}"><i class="dw dw-logout"></i>
                        Log Out</a>
                </div>
            </div>
        </div>
    </div>
    </div>