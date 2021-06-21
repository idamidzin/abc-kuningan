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
                @if(count($transaksi) > 0)
                @foreach($transaksi as $row)
                    <div class="col-sm-12 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="d-inline">
                                    {{ $row->Paket->nama }}
                                    @if($row->status == 0)
                                        <span class="badge badge-secondary">Pending</span>
                                    @elseif($row->status == 1)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Kedaluarsa</span>
                                    @endif
                                </h5>
                                <div class="float-right">
                                    dibuat pada tanggal 
                                    <i>{{ tanggalIndo($row->created_at) }}</i>
                                    @if($row->status == 0)
                                    <button type="button" title="delete" onclick="willRemove('{{ $row->hashid }}','DESTROY')" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>Invoice #{{ $row->hashid }}</h4>
                                        <table style="width: 100% !important; border: none !important;" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="30%">Total Pembayaran</td>
                                                <td>: @rupiah($row->harga)</td>
                                            </tr>
                                            <tr>
                                                <td>Tempat</td>
                                                <td>: {{ $row->Lapang->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td>Waktu</td>
                                                <td>: {{ ucwords($row->hari) }}, {{ date('H:i', strtotime($row->jam_mulai)) }} - {{ date('H:i', strtotime($row->jam_selesai)) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Berlaku</td>
                                                <td>: {{ rangedate($row->tanggal_mulai, $row->tanggal_selesai) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>Transaksi</h4>
                                        <table style="width: 100% !important; border: none !important;" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="30%">Bukti Pembayaran</td>
                                                <td>
                                                    @if($row->bukti_pembayaran)
                                                       : <a target="_blank" href="{{ asset('storage/bukti_pembayaran/'.$row->bukti_pembayaran) }}" class="img-pop-up">Lihat bukti</a>
                                                    @else
                                                    <form action="{{ route('upload.bukti') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                                        <input type="file" name="bukti_pembayaran" class="form-control">
                                                        <button class="genric-btn primary small d-block mt-3">Kirim</button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"> 
                                                    @if($row->status == 0)
                                                    @if($row->bukti_pembayaran)
                                                    <form action="{{ route('upload.bukti') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                                        <input type="file" name="bukti_pembayaran" class="form-control">
                                                        <button class="genric-btn primary small d-block mt-3">Kirim Ulang</button>
                                                    </form>
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                <div class="col-sm-12">
                    <div class="alert alert-danger text-center">
                        Transaksi tidak ditemukan !
                    </div>
                </div>
                @endif
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
