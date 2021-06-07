@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Transaksi
	</div>
</div>
@if(!$transaksi)
<div class="row">
	<div class="col-sm-12">
		<div class="card b mb-2 p-5">
			<div class="row">
				<div class="col-sm-6 pt-5">
					<h3>Untuk melihat detail transaksi di Komputer anda :</h3>
					<br>
					<ol>
						<li>Buka Aplikasi Administrator Booking Online di Smartphone anda</li>
						<li>Login menggunakan username dan password untuk memiliki hak akses</li>
						<li>Ketuk Menu Scann</li>
						<li>Arahkan smartphone anda ke QR-Code peminjam alat</li>
					</ol>
				</div>
				<div class="col-sm-6 text-center">
					<img src="{{ asset('images/pindai.png') }}" width="300px;">
				</div>
			</div>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-lg-3">
		<div class="card b mb-2">
			<div class="card-header bb">
				<h4 class="card-title">Ringkasan Pesanan</h4>
			</div>
			<div class="card-body bt">
				<h4 class="b0">#INVOICE-{{ $transaksi->kode_booking }}</h4>
				@if($transaksi->status == 1)
					<span class="badge badge-info">Menunggu Konfirmasi Pembayaran</span>
				@elseif($transaksi->status == 2)
					<span class="badge badge-warning">Di terima</span>
				@elseif($transaksi->status == 3)
					<span class="badge badge-success">Selesai</span>
				@elseif($transaksi->status == 4)
					<span class="badge badge-danger">Cancel</span>
				@endif
			</div>
			<table class="table">
				<tbody>
					<tr>
						<td>Nama Lengkap</td>
						<td>
							<div class="text-right text-bold">{{ $transaksi->User->nama }}</div>
						</td>
					</tr>
					<tr>
						<td>No Hp</td>
						<td>
							<div class="text-right text-bold">{{ $transaksi->User->nohp }}</div>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="table">
				<tbody>
					<tr>
						<td>Total</td>
						<td>
							<div class="text-right text-bold">Rp. {{ number_format($transaksi->total_harga, 0,',','.') }}</div>
						</td>
					</tr>
					<tr>
						<td>Diskon</td>
						<td>
							<div class="text-right text-bold">{{ $transaksi->diskon ? $transaksi->diskon : '-' }}</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="card-body">
				<div class="clearfix">
					<div class="float-right text-right">
						<div class="text-bold">Rp. {{ number_format($transaksi->total_harga, 0,',','.') }}</div>
						<div class="text-sm">Rupiah</div>
					</div>
					<div class="float-left text-bold text-dark">TOTAL BAYAR</div>
				</div>
			</div>
			<div class="card-body">
				@if($transaksi->status == 1)
					<a href="{{ route('transaksi.tindakan') }}?kode={{$transaksi->hashid}}&param=2" class="btn btn-primary btn-sm btn-block">Terima</a>
				@elseif($transaksi->status == 2)
					<a href="{{ route('transaksi.tindakan') }}?kode={{$transaksi->hashid}}&param=3" class="btn btn-success btn-sm btn-block">Selesai</a>
				@endif
				<small class="text-muted">* Silahkan klik selesai untuk selesaikan status pinjam</small>
			</div>
		</div>
	</div>
	<div class="col-lg-9">
		<div class="container-md mx-0">
			<!-- Checkout Process-->
			<form action="#" method="post" novalidate="novalidate">
				<div id="accordion">
					<!-- Shipping Method-->
					<div class="card b mb-2">
						<div class="card-header">
							<h4 class="card-title"><a class="text-inherit" data-toggle="collapse" data-parent="#accordion" href="#acc1collapse4">Cek Kelengkapan Alat</a></h4>
						</div>
						<div class="collapse show" id="acc1collapse4">
							<div class="card-body" id="collapse04">
								<table class="table">
									<thead class="bg-gray-lighter">
										<tr>
											<th class="wd-xxs"><em class="fa fa-check text-muted ml-1"></em></th>
											<th>Alat</th>
											<th>Jumlah</th>
											<th>Harga</th>
										</tr>
									</thead>
									<tbody>
										@foreach($transaksi->BookingDetail as $row)
										<tr>
											<td>
												<div class="c-radio">
													<label>
														<input type="checkbox" name="checkout-ship" value="{{ $row->id }}" />
														<span class="fa fa-check"></span>
													</label>
												</div>
											</td>
											<td><strong>{{ $row->Produk->nama }}</strong></td>
											<td class="text-center">{{ $row->jumlah }}</td>
											<td><strong class="h4 text-green">{{ number_format($row->harga, 0,',','.') }}</strong></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endif

@endsection
@section('scripts')
<script src="{{ mix('/js/sweetalert.js') }}"></script>
<script src="{{ mix('/js/datatable.js') }}"></script>
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script type="text/javascript">

	Pusher.logToConsole = true;
	<?php $pusherkey = env('PUSHER_APP_KEY',false); ?>

	var pusher = new Pusher('a1fe9e7230414caaa312', {
		cluster: 'ap1'
	});

	var channel = pusher.subscribe('my-channel');
	channel.bind('my-event', function(data) {
		if (data.message=="ok") 
		{
			window.location.href="{{ route('transaksi.index') }}?kode_booking="+data.kode_booking+"";
		}
	});

</script>
@endsection
