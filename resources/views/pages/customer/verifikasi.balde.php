@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.common-banner')
<section class="login_box_area section_gap">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				@if(auth()->user())
				@if(auth()->user()->verifikasi == 0)
				@if( session('msg') )
				<?php $msg = session('msg'); ?>
					<h6 style="color: white;">{!! $msg['text'] !!}</h6>
				@else
					<h6 style="color: white;">Anda belum verifikasi akun anda. <a href="{{ route('daftar.customer.verifikasi') }}" style="color: blue;">Verifikasi Sekarang</a></h6>
				@endif
				@endif
				@endif
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
@endsection
