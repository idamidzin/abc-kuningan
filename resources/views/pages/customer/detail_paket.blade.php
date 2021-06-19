@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.common-banner')

    <!--================Single Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <div class="s_Product_carousel">
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ asset('storage/paket/'.$paket->gambar) }}" alt="">
                        </div>
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ asset('storage/paket/'.$paket->gambar) }}" alt="">
                        </div>
                        <div class="single-prd-item">
                            <img class="img-fluid" src="{{ asset('storage/paket/'.$paket->gambar) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3>{{ $paket->nama }}</h3>
                        @if($paket->diskon)
                        <h2>{{'Rp. '.number_format($paket->harga-$paket->diskon, 0,',','.')}}</h2>
                        <h2 class="l-through">{{'Rp. '.number_format($paket->harga, 0,',','.')}}</h2>
                        @else
                        <h2>{{'Rp. '.number_format($paket->harga, 0,',','.')}}</h2>
                        @endif
                        <ul class="list mb-3">
                            <li><a class="active" href="#"><span>Durasi Waktu</span> : {{$paket->jumlah_jam.' Menit'  }}</a></li>
                            @if($paket->for_use != 'non-member')
                            <li><a href="#"><span>Jangka : </span> : {{ $paket->jumlah_hari }} Hari</a></li>
                            @endif
                        </ul>
                        {!! json_decode($paket->deskripsi) !!}
                        <div class="card_area d-flex align-items-center">
                            <a class="primary-btn" href="{{ route('paket.beli', $paket->hashid) }}">Beli Paket</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->
    <br><br><br>
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
