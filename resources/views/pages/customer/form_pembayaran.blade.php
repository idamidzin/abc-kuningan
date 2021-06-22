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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>RINCIAN PEMBAYARAN</h4>
                </div>
                <div class="card-body">
                    <h4>Invoice #{{ $booking->hashid }}</h4>
                    <table style="width: 100% !important; border: none !important;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Total Pembayaran</td>
                            <td>: <b>@rupiah($booking->harga)</b></td>
                        </tr>
                        @if($booking->kategori_pembayaran == 1)
                        <tr>
                            <td width="30%">
                                @if($booking->Paket->for_use == 'member')
                                Perbulan
                                @else
                                    @if($isNewDiklat == true)
                                    Harga Awal / Harga Perbulan
                                    @else
                                    Perbulan
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($booking->Paket->for_use == 'member')
                                : @rupiah($booking->harga/($booking->jumlah_hari/30))
                                @else
                                    @if($isNewDiklat == true)
                                    : @rupiah($booking->Paket->harga) / @rupiah($booking->Paket->harga_perbulan)
                                    @else
                                    : @rupiah($booking->Paket->harga_perbulan)
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endif
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
                    </table>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">UPLOAD BUKTI PEMBAYARAN</h5>
                    <!-- Perbulan -->
                    @if($booking->kategori_pembayaran == '0') 
                    @foreach($booking->PembayaranLimit as $bukti)
                    <form action="{{ route('upload.bukti', $bukti->hashid) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" value="{{ $booking->id }}">
                        <div class="form-group">
                            <input type="file" name="bukti_pembayaran" class="form-control d-inline" required>
                            <button class="genric-btn primary small d-inline mt-3">
                                @if($booking->Paket->for_use == "non-member")
                                Kirim (Bukti Pembayaran)
                                @else
                                Kirim (Bukti Pembayaran Lunas)
                                @endif
                            </button>
                            @if($bukti->bukti_pembayaran)
                            <a target="_blank" href="{{ asset('storage/bukti_pembayaran/'.$bukti->bukti_pembayaran) }}" class="ml-3 img-pop-up">Lihat bukti</a>
                            @endif
                        </div>
                        <hr>
                    </form>
                    @endforeach
                    @else
                    @foreach($booking->Pembayaran as $bukti)
                    <form action="{{ route('upload.bukti', $bukti->hashid) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" value="{{ $booking->id }}">
                        <div class="form-group">
                            <input type="file" name="bukti_pembayaran" class="form-control d-inline" required>
                            <button class="genric-btn primary small d-inline mt-3">
                                @if($booking->Paket->for_use == "non-member")
                                Kirim (Bukti Pembayaran)
                                @else
                                Kirim (Bukti Pembayaran Bulan {{ $loop->iteration }})
                                @endif
                            </button>
                            @if($bukti->bukti_pembayaran)
                            <a target="_blank" href="{{ asset('storage/bukti_pembayaran/'.$bukti->bukti_pembayaran) }}" class="ml-3 img-pop-up">Lihat bukti</a>
                            @endif
                        </div>
                        <hr>
                    </form>
                    @endforeach
                    @endif
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
