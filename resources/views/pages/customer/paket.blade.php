@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.common-banner')
<div class="container mt-5">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <div class="sidebar-categories">
                <div class="head">Pilihan Paket</div>
                <ul class="main-categories">
                    <li class="main-nav-list"><a href="{{ route('paket') }}?for_use=member"><span
                        class="lnr lnr-arrow-right"></span>Member<span class="number">({{ $member_count }})</span></a>
                    </li>
                    <li class="main-nav-list"><a href="{{ route('paket') }}?for_use=non-member"><span
                        class="lnr lnr-arrow-right"></span>Booking<span class="number">({{ $non_member_count }})</span></a>
                    </li>
                    <li class="main-nav-list"><a href="{{ route('paket') }}?for_use=diklat"><span
                        class="lnr lnr-arrow-right"></span>Pelatihan<span class="number">({{ $diklat_count }})</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8 col-md-7">
            <!-- Start Filter Bar -->
            <div class="filter-bar d-flex flex-wrap align-items-center">
                <div class="container pt-3">
                    <h5 style="color: white !important;">Silahkan ada beberapa pilihan paket yang bisa anda nikmati !</h5>
                </div>
            </div>
            <!-- End Filter Bar -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
                <div class="row">
                    <!-- single product -->
                    @foreach($pakets as $paket)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-product">
                            <img class="img-fluid" src="{{ asset('storage/paket/'.$paket->gambar) }}" alt="">
                            <div class="product-details">
                                <h6>{{ $paket->nama }}</h6>
                                <div class="price">
                                    @if($paket->diskon)
                                    <h6>{{'Rp. '.number_format($paket->harga-$paket->diskon, 0,',','.')}}</h6>
                                    <h6 class="l-through">{{'Rp. '.number_format($paket->harga, 0,',','.')}}</h6>
                                    @else
                                    <h6>{{'Rp. '.number_format($paket->harga, 0,',','.')}}</h6>
                                    @endif
                                </div>
                                <div class="prd-bottom">
                                    @if($paket->for_use == 'non-member')
                                    <a href="" class="social-info">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">Booking</p>
                                    </a>
                                    <a href="" class="social-info">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text">Lihat Detail</p>
                                    </a>
                                    @elseif($paket->for_use == 'member')
                                    <a href="" class="social-info">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">Member</p>
                                    </a>
                                    <a href="" class="social-info">
                                        <span class="lnr lnr-move"></span>
                                        <p class="hover-text">Lihat Detail</p>
                                    </a>
                                    @else
                                    <a href="" class="social-info">
                                        <span class="ti-bag"></span>
                                        <p class="hover-text">Pelatihan</p>
                                    </a>
                                    <a href="" class="social-info">
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
            </section>
            <!-- End Best Seller -->
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ mix('/js/sparkline.js') }}"></script>
<script src="{{ mix('/js/easypiechart.js') }}"></script>
<script src="{{ mix('/js/flot.js') }}"></script>
<script src="{{ mix('/js/sweetalert.js') }}"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
</script>
@endsection
