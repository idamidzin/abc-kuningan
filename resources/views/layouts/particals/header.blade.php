@if(auth()->user())
    @if(auth()->user()->verifikasi == 0)
        @if( session('msg') )
        <?php $msg = session('msg'); ?>
        <header class="header_area sticky-header" style="">
            <div class="main_menu">
                <nav class="navbar navbar-expand-lg navbar-light main_box bg-danger">
                    <div class="container" style="padding-top: 15px; padding-bottom: 10px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 style="color: white;">
                                    {!! $msg['text'] !!}
                                </h6>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        @else
        <header class="header_area sticky-header" style="margin-top: 0px;">
            <div class="main_menu">
                <nav class="navbar navbar-expand-lg navbar-light main_box" style="background-color: #fb97a1 !important;">
                    <div class="container" style="padding-top: 15px; padding-bottom: 10px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 style="color: white;">Anda belum verifikasi akun anda. <a href="{{ route('daftar.customer.verifikasi') }}" style="color: blue;">Verifikasi Sekarang</a></h6>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        @endif
    @endif
@endif

@if(auth()->user())
    @if(auth()->user()->verifikasi == 0)
    <header class="header_area sticky-header" style="margin-top: 60px;">
    @else
    <header class="header_area sticky-header" style="margin-top: 0px;">
    @endif
@else
    <header class="header_area sticky-header" style="margin-top: 0px;">
@endif
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="index.html"><img src="{{ asset('customer/img/logo.png') }}" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                <ul class="nav navbar-nav menu_nav ml-auto">
                    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item {{ request()->is('paket') ? 'active' : '' }}"><a class="nav-link" href="{{ route('paket') }}">Paket</a></li>
                    <li class="nav-item {{ request()->is('jadwal') ? 'active' : '' }}"><a class="nav-link" href="{{ route('jadwal') }}">Jadwal</a></li>
                    @if(auth()->user())
                    <li class="nav-item submenu dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">{{ auth()->user()->nama_lengkap }}
                        &nbsp;
                        @if($booking_count > 0)
                            <span class="badge badge-danger">*</span>
                        @endif
                    </a>
                        <ul class="dropdown-menu">
                            <li class="nav-item"><a class="nav-link" href="{{ '' }}">Profile</a></li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ '' }}">
                                    @if($paket_aktif_count > 0)
                                        Paket Aktif<span class="badge badge-danger ml-5">{{ $paket_aktif_count }}</span>
                                    @else
                                        Paket Aktif
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('transaksi') }}">
                                    @if($transaksi_baru_count > 0)
                                        Transaksi<span class="badge badge-danger ml-5">{{ $transaksi_baru_count }}</span>
                                    @else
                                        Transaksi
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('logout.customer') }}">Logout</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login.customer') }}">Masuk/Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
</header>