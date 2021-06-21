@extends('layouts.horizontal')
@section('content')

<div class="container mt-5 mb-5" style="margin-top: 150px !important;">
    <div class="row">
        <div class="col-lg-4">
            <div class="blog_right_sidebar">
                <aside class="single_sidebar_widget author_widget">
                    @if(auth()->user()->foto)
                    <img class="author_img rounded-circle" src="{{ asset('storage/profile/'.auth()->user()->foto) }}" alt="" width="150px" height="150px">
                    @else
                    <img class="author_img rounded-circle" src="{{ asset('storage/profile/default.png') }}" alt="" width="150px" height="150px">
                    @endif
                    <h4>{{ auth()->user()->nama_lengkap }}</h4>
                    <p>{{ auth()->user()->email }}</p>
                    <div class="social_icon">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-github"></i></a>
                        <a href="#"><i class="fa fa-behance"></i></a>
                    </div>
                    <p>{{ auth()->user()->alamat }}</p>
                    <a href="{{ route('profile.edit') }}" class="genric-btn primary-border small mt-2">Edit Profile</a>
                </aside>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                @if( session('msg') )
                <?php $msg = session('msg'); ?>
                    <div class="col-sm-12">
                        <div class="alert alert-{{ $msg['type'] }} alert-remove">
                            {!! $msg['text'] !!}
                        </div>
                    </div>
                @endif
                @foreach($records_aktif as $row)
                <div class="col-sm-4">
                    <div class="card mt-2" style="background-color: #404040; color: white !important;">
                        <div class="card-body">
                            <h4 style="color: white;">{{ $row->Paket->nama }}</h4>
                            <span class="genric-btn warning small mt-2">Aktif</span>
                            @if($row->Paket->for_use == 'member')
                            <h6 class="text-white mt-2">Setiap hari {{ ucwords($row->hari) }}</h6>
                            <h6 class="text-white">Pukul {{ date('H:i', strtotime($row->jam_mulai)).'-'.date('H:i', strtotime($row->jam_selesai)) }}</h6>
                            <h6 class="text-white">Masa Aktif ({{ rangeDate($row->tanggal_mulai, $row->tanggal_selesai) }})</h6>
                            @elseif($row->Paket->for_use == 'non-member')
                            <h6 class="text-white mt-2">Hari {{ ucwords($row->hari) }}</h6>
                            <h6 class="text-white">Pukul {{ date('H:i', strtotime($row->jam_mulai)).'-'.date('H:i', strtotime($row->jam_selesai)) }}</h6>
                            <h6 class="text-white">Masa Aktif ({{ rangeDate($row->tanggal_mulai, $row->tanggal_selesai) }})</h6>
                            @else
                            <h6 class="text-white mt-2">Setiap hari {{ ucwords($row->hari) }}</h6>
                            <h6 class="text-white">Pukul {{ date('H:i', strtotime($row->jam_mulai)).'-'.date('H:i', strtotime($row->jam_selesai)) }}</h6>
                            <h6 class="text-white">Masa Aktif ({{ rangeDate($row->tanggal_mulai, $row->tanggal_selesai) }})</h6>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
</script>
@endsection
