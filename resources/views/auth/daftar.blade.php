@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.common-banner')
<section class="login_box_area section_gap">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="login_box_img">
					<img class="img-fluid" src="{{ asset('customer/img/login.jpg') }}" alt="">
					<div class="hover">
						<h4>Anrimusthi Badminton Centre Kuningan</h4>
						<p>Jika sudah memiliki akun, silahkan untuk masuk dan nikmati berbagai paket yang bisa anda gunakan</p>
						<a class="primary-btn" href="{{ route('login.customer') }}">Masuk</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="login_form_inner">
					<h3>Daftar untuk melanjutkan</h3>
					@if( session('msg') )
					<?php $msg = session('msg'); ?>
					<div class="login_form alert alert-{{ $msg['type'] }} alert-remove">
						{!! $msg['text'] !!}
					</div>
					@endif
					<form class="row login_form" action="{{ route('daftar.customer.proses') }}" method="POST">
						@csrf
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap" required >
						</div>
						<div class="col-md-12 form-group">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required >
						</div>
						<div class="col-md-12 form-group">
							<input type="number" class="form-control" name="nohp" value="{{ old('nohp') }}" placeholder="Nomor HP" required  onkeypress="return event.charCode >= 48 && event.charCode <=57">
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required >
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required >
						</div>
						<div class="col-md-12 form-group">
							<button type="submit" class="primary-btn">Daftar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
@endsection
