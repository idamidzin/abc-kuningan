@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body bg-gray-dark rounded p-5">
                <h1>Selamat Datang</h1>
                di halaman Administrator Anrimusthi Badminton Centre Kuningan <strong style="color: yellow">{{ucwords(auth()->user()->nama)}}</strong style="color: yellow">
            </div>
        </div>
    </div>
</div>
<!-- START cards box-->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-purple-dark justify-content-center rounded-left"><em class="fas fa-shopping-bag fa-3x"></em></div>
            <div class="col-8 py-3 bg-purple rounded-right">
                <div class="h2 mt-0">{{ count($produk) }}</div>
                <div class="text-uppercase">Paket</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-primary-dark justify-content-center rounded-left"><em class="fas fa-handshake fa-3x"></em></div>
            <div class="col-8 py-3 bg-primary rounded-right">
                <div class="h2 mt-0">{{ count($booking) }}</div>
                <div class="text-uppercase">Booking Baru</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-warning-dark justify-content-center rounded-left"><em class="icon-globe fa-3x"></em></div>
            <div class="col-8 py-3 bg-warning rounded-right">
                <div class="h2 mt-0">{{ count($user) }}</div>
                <div class="text-uppercase">Customer</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-12">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-green justify-content-center rounded-left">
                <div class="text-center">
                    <div class="text-sm" data-now="" data-format="MMMM"></div>
                    <br />
                    <div class="h2 mt-0" data-now="" data-format="D"></div>
                </div>
            </div>
            <div class="col-8 py-3 rounded-right">
                <div class="text-uppercase" data-now="" data-format="dddd"></div>
                <br />
                <div class="h2 mt-0" data-now="" data-format="h:mm"></div>
                <div class="text-muted text-sm" data-now="" data-format="a"></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 mt-2">
            <video id="preview" style="width: 350px; border-radius: 10px; overflow: hidden;"></video>
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
    $(document).ready(function(){
        // scan();
    });

    function scan(){
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
            console.log('QR-Code', content);
            swal(content, 'success');
            // scanner.stop()
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('Camera tida ada');
            }
        }).catch(function (e) {
            console.error(e);
        });
    }
</script>
@endsection
