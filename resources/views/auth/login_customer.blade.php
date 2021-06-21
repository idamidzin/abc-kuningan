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
						<p>Jadilah bagian dari kami, pilihannya hidup sehat dengan pola olahraga atau menjadi atlet dengan meningkatkan kualitas bermain Bulutangkis ?</p>
						<a class="primary-btn" href="{{ route('daftar.customer') }}">Daftar Akun</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="login_form_inner">
					<h3>Masuk untuk melanjutkan</h3>
					@if( session('msg') )
					<?php $msg = session('msg'); ?>
					<div class="login_form alert alert-{{ $msg['type'] }} alert-remove">
						{!! $msg['text'] !!}
					</div>
					@endif
					<form class="row login_form" action="{{ route('login.customer.proses') }}" method="POST">
						@csrf
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="username" placeholder="Username" required>
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" name="password" placeholder="Password" required>
						</div>
						<div class="col-md-12 form-group">
							<button type="submit" class="primary-btn">Masuk</button>
							<!-- <a href="#">Lupa Password ?</a> -->
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
