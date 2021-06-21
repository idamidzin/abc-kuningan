@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.banner')
<!-- start features Area -->
<section class="features-area section_gap">
    <div class="container">
        <div class="row features-inner">
            <!-- single features -->
            <div class="col-lg-4 offset-0">
                <div class="single-features">
                    <div class="f-icon">
                        <a href="{{ route('paket') }}?for_use=member">                            
                            <img src="{{ asset('customer/img/features/f-icon1.png') }}" alt="" width="200px;">
                        </a>
                    </div>
                    <h6>Member</h6>
                    <p>Yuk berlangganan</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-4">
                <div class="single-features">
                    <div class="f-icon">
                        <a href="{{ route('paket') }}?for_use=non-member">                            
                            <img src="{{ asset('customer/img/features/f-icon2.png') }}" alt="" width="200px;">
                        </a>
                    </div>
                    <h6>Booking</h6>
                    <p>Booking lapangan</p>
                </div>
            </div>
            <!-- single features -->
            <div class="col-lg-4">
                <div class="single-features">
                    <div class="f-icon">
                        <a href="{{ route('paket') }}?for_use=diklat">                            
                            <img src="{{ asset('customer/img/features/f-icon3.png') }}" alt="" width="200px;">
                        </a>
                    </div>
                    <h6>Pelatihan</h6>
                    <p>Gabung untuk menjadi atlet</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end features Area -->

<!-- Start category Area -->
<section class="category-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="single-deal">
                            <div class="overlay"></div>
                            <img class="img-fluid w-100" src="{{ asset('storage/galeri/c1.jpg') }}" alt="">
                            <a href="{{ asset('storage/galeri/c1.jpg') }}" class="img-pop-up" target="_blank">
                                <div class="deal-details">
                                    <h6 class="deal-title">Raket for Sports</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="single-deal">
                            <div class="overlay"></div>
                            <img class="img-fluid w-100" src="{{ asset('storage/galeri/a2.jpg') }}" alt="">
                            <a href="{{ asset('storage/galeri/a2.jpg') }}" class="img-pop-up" target="_blank">
                                <div class="deal-details">
                                    <h6 class="deal-title">Raket for Sports</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="single-deal">
                            <div class="overlay"></div>
                            <img class="img-fluid w-100" src="{{ asset('storage/galeri/a1.jpg') }}" alt="">
                            <a href="{{ asset('storage/galeri/a1.jpg') }}" class="img-pop-up" target="_blank">
                                <div class="deal-details">
                                    <h6 class="deal-title">Product for Couple</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="single-deal">
                            <div class="overlay"></div>
                            <img class="img-fluid w-100" src="{{ asset('storage/galeri/c2.jpg') }}" alt="">
                            <a href="{{ asset('storage/galeri/c2.jpg') }}" class="img-pop-up" target="_blank">
                                <div class="deal-details">
                                    <h6 class="deal-title">Raket for Sports</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-deal">
                    <div class="overlay"></div>
                    <img class="img-fluid w-100" src="{{ asset('storage/galeri/best.jpg') }}" alt="">
                    <a href="{{ asset('storage/galeri/best.jpg') }}" class="img-pop-up" target="_blank">
                        <div class="deal-details">
                            <h6 class="deal-title">Raket for Sports</h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End category Area -->

<!-- start product Area -->
<section class="section_gap">
    <!-- single product slide -->
    <div class="single-product-slider">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Paket Terbaru</h1>
                        <p>Dengan berbagai paket memberikan pilihan yang tepat untuk anda memilih sesuai dengan keinginan</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- single product -->
                @foreach($pakets as $paket)
                <div class="col-lg-3 col-md-6">
                    <div class="single-product">
                        <img class="img-fluid" src="{{ asset('storage/paket/'.$paket->gambar) }}" alt="">
                        <div class="product-details">
                            <h6>{{ $paket->nama }}</h6>
                            <div class="price">
                                <h6>{{'Rp. '.number_format($paket->harga-$paket->diskon, 0,',','.')}}</h6>
                                <h6 class="l-through">$210.00</h6>
                            </div>
                            <div class="prd-bottom">
                                @if($paket->for_use == 'non-member')
                                <a href="{{ route('paket.detail', $paket->hashid) }}" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">Booking</p>
                                </a>
                                <a href="{{ route('paket.detail', $paket->hashid) }}" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">Lihat Detail</p>
                                </a>
                                @elseif($paket->for_use == 'member')
                                <a href="{{ route('paket.detail', $paket->hashid) }}" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">Member</p>
                                </a>
                                <a href="{{ route('paket.detail', $paket->hashid) }}" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">Lihat Detail</p>
                                </a>
                                @else
                                <a href="{{ route('paket.detail', $paket->hashid) }}" class="social-info">
                                    <span class="ti-bag"></span>
                                    <p class="hover-text">Pelatihan</p>
                                </a>
                                <a href="{{ route('paket.detail', $paket->hashid) }}" class="social-info">
                                    <span class="lnr lnr-move"></span>
                                    <p class="hover-text">Lihat Detail</p>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- end product Area -->

<!-- Start exclusive deal Area -->
<section class="exclusive-deal-area">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 no-padding exclusive-left">
                <div class="row clock_sec clockdiv" id="clockdiv">
                    <div class="col-lg-12">
                        <h1>Exclusive !! Paket Diskon</h1>
                        <p>Segera dapatkan paket dengan potongan 15K</p>
                    </div>
                    <div class="col-lg-12">
                        <div class="row clock-wrap">
                            <div class="col clockinner1 clockinner">
                                <h1 class="days">150</h1>
                                <span class="smalltext">Days</span>
                            </div>
                            <div class="col clockinner clockinner1">
                                <h1 class="hours">23</h1>
                                <span class="smalltext">Hours</span>
                            </div>
                            <div class="col clockinner clockinner1">
                                <h1 class="minutes">47</h1>
                                <span class="smalltext">Mins</span>
                            </div>
                            <div class="col clockinner clockinner1">
                                <h1 class="seconds">59</h1>
                                <span class="smalltext">Secs</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="" class="primary-btn">Beli Paket</a>
            </div>
            <div class="col-lg-6 no-padding exclusive-right">
                <div class="">
                    <!-- single exclusive carousel -->
                    <?php
                    $paket_diskon = \App\Models\Paket::limit(1)->first();
                    ?>
                    <div class="single-exclusive-slider">
                        <img class="img-fluid" src="{{ asset('storage/paket/'.$paket_diskon->gambar) }}" alt="" style="border-radius: 10%; width:300px;">
                        <div class="product-details">
                            <div class="price pt-2">
                                @if($paket_diskon->diskon)
                                <h6>{{'Rp. '.number_format($paket_diskon->harga-$paket_diskon->diskon, 0,',','.')}}</h6>
                                <h6 class="l-through">{{'Rp. '.number_format($paket_diskon->harga, 0,',','.')}}</h6>
                                @else
                                <h6>{{'Rp. '.number_format($paket_diskon->harga, 0,',','.')}}</h6>
                                @endif
                            </div>
                            <h4>{{ $paket_diskon->nama }}</h4>
                            <div class="add-bag d-flex align-items-center justify-content-center">
                                <span class="add-text text-uppercase">{{ $paket_diskon->deskripsi }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End exclusive deal Area -->

<!-- Start brand Area -->
<section class="brand-area section_gap">
    <div class="container">
        <div class="row">
            <!-- <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{ asset('customer/img/brand/1.png') }}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{ asset('customer/img/brand/2.png') }}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{ asset('customer/img/brand/3.png') }}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{ asset('customer/img/brand/4.png') }}" alt="">
            </a>
            <a class="col single-img" href="#">
                <img class="img-fluid d-block mx-auto" src="{{ asset('customer/img/brand/5.png') }}" alt="">
            </a> -->
        </div>
    </div>
</section>
<!-- End brand Area -->

@endsection
@section('scripts')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
</script>
@endsection
