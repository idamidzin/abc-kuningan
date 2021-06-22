@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.common-banner')

<!--================Single Product Area =================-->
<div class="container mt-5">
    <div class="row">
        @if( session('msg') )
        <?php $msg = session('msg'); ?>
        <div class="col-sm-12">
            <div class="alert alert-{{ $msg['type'] }} alert-remove">
                {!! $msg['text'] !!}
            </div>
        </div>
        @endif
        <div class="col-sm-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h4>INFO PEMBAYARAN</h4>
                </div>
                <div class="card-body">
                    <h4>Invoice #{{ $booking->hashid }}</h4>
                    <table style="width: 100% !important; border: none !important;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Total Pembayaran</td>
                            <td>
                                :
                                <b style="text-decoration: line-through gray; display: none;" id="harga-coret">@rupiah($booking->harga)</b>
                                <b style="display: show;" id="harga-normal">@rupiah($booking->harga)</b>
                                @if($booking->Paket->for_use == 'member')
                                <b style="text-decoration: line-through gray; display: none;" id="harga-coret-member">/ @rupiah($booking->harga/($booking->jumlah_hari/30)) (Perbulan)</b>
                                <b style="display: show;" id="harga-normal-member">/ @rupiah($booking->harga/($booking->jumlah_hari/30)) (Perbulan)</b>
                                @elseif($booking->Paket->for_use == 'diklat')
                                    @if($isNewDiklat == true)
                                    <b style="text-decoration: line-through gray; display: none;" id="harga-coret-member">
                                        / @rupiah($booking->Paket->harga) (Awal Bulan)
                                    </b>
                                    <b style="display: show;" id="harga-normal-member">
                                        / @rupiah($booking->Paket->harga) (Awal Bulan)
                                    </b>
                                    @else
                                    <b style="text-decoration: line-through gray; display: none;" id="harga-coret-member">
                                        / @rupiah($booking->Paket->harga_perbulan) (Perbulan)
                                    </b>
                                    <b style="display: show;" id="harga-normal-member">
                                        / @rupiah($booking->Paket->harga_perbulan) (Perbulan)
                                    </b>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td>: {{ $booking->Lapang->nama }}</td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>: {{ ucwords($booking->hari) }}, {{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</td>
                        </tr>
                        <tr>
                            <td>Berlaku</td>
                            <td>: {{ rangedate($booking->tanggal_mulai, $booking->tanggal_selesai) }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;">Transfer</td>
                            <td>: BRI <strong>4280 01 024270 534</strong> <br> &nbsp;&nbsp;Deva Anrimusthi</td>
                        </tr>
                        <form action="{{ route('info-pembayaran-update', $booking->hashid) }}" method="POST">
                            @method('PUT')
                            @csrf 
                            <tr>
                                @if($booking->Paket->for_use == 'member' || $booking->Paket->for_use == 'diklat')
                                <td style="vertical-align:top;">Metode Bayar</td>
                                <td>: 
                                    <input type="checkbox" name="kategori_pembayaran" id="checkbox" onclick="checkBox()"> Perbulan
                                </td>
                            </tr>
                            <tr>
                                @endif
                                <td colspan="2">
                                    <button class="genric-btn primary small mt-2">Ajukan Metode</button>
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->
<br><br><br>
<form id="action-form" action="" method="POST">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <input type="hidden" name="id">
</form>
@endsection
@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        $('#harga-normal').show();
        $('#harga-coret').hide();

        $('#harga-normal-member').hide();
        $('#harga-coret-member').show();
        checkbox();
    });

    function checkBox(){
        if ($('#checkbox:checked').is(':checked')) {
            $('#harga-normal').hide();
            $('#harga-coret').show();

            $('#harga-normal-member').show();
            $('#harga-coret-member').hide();
        }else{
            $('#harga-normal').show();
            $('#harga-coret').hide();

            $('#harga-normal-member').hide();
            $('#harga-coret-member').show();
        }
    }

    function execRemove(method, hashid) {
        $("#action-form").attr('action', 'transaksi/delete/' + hashid);
        $("#action-form input[name=_method]").val(method);
        $("#action-form").submit();
    }

    function willRemove(id, method) {
        swal({
            title: "Apakah Anda Yakin?",
            text: "anda yakin menghapus transaksi ini?",
            icon: "warning",
            buttons: ["Batal", "Ya"]
        })
        .then(function(willDelete) {
            if (willDelete) {
                if (method === "DELETE") execRemove('PATCH', id)
                    else execRemove('DELETE', id)
                }
        });
    };
</script>
@endsection
