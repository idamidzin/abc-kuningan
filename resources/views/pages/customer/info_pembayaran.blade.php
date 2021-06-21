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
                            <td>: <b>@rupiah($booking->harga)</b></td>
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
                        <tr>
                            <td colspan="2">
                                <form action="{{ route('upload.bukti') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $booking->id }}">
                                    <input type="file" name="bukti_pembayaran" class="form-control">
                                    <button class="genric-btn primary small d-block mt-3">Kirim</button>
                                </form>
                            </td>
                        </tr>
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
