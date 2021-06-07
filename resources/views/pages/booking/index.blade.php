@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<h3>Data Booking ({{ $status ? ucwords($status) : 'Baru' }})</h3>
		</div>
		<div class="col-sm-6">
			<div class="float-right">
				<a href="{{ route('booking.create') }}" class="btn btn-success">Booking Baru</a>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-4">
	<!-- DATATABLE DEMO 1-->
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="row">
					<div class="col-sm-8">
						<a href="{{ route('booking.index') }}" class="{{ $status ? 'text-primary':'text-muted' }}"> Booking Baru
							<span class="badge badge-pill {{ $status == '' ? 'badge-primary' : 'bg-gray' }}">{{ $booking_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('booking.index') }}?status=terima" class="{{ $status == 'terima' ? 'text-muted':'text-warning' }}">
							Booking Terima
							<span class="badge badge-pill {{ $status == 'terima' ? 'badge-warning' : 'bg-gray' }}">{{ $terima_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('booking.index') }}?status=selesai" class="{{ $status == 'selesai' ? 'text-muted':'text-success' }}">
							Booking Selesai
							<span class="badge badge-pill {{ $status == 'selesai' ? 'badge-success' : 'bg-gray' }}">{{ $selesai_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('booking.index') }}?status=cancel" class="{{ $status == 'cancel' ? 'text-muted':'text-purple' }}">
							Cancel
							<span class="badge badge-pill {{ $status == 'cancel' ? 'badge-purple' : 'bg-gray' }}">{{ $cancel_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('booking.index') }}?status=trash" class="{{ $status == 'trash' ? 'text-muted':'text-danger' }}">
							Sampah
							<span class="badge badge-pill {{ $status == 'trash' ? 'badge-danger' : 'bg-gray' }}">{{ $trash_count }}</span>
						</a>
					</div>
					<div class="col-sm-4">
						<form>
							<div class="row">
								<div class="col-sm-8">
									<select class="custom-select custom-select-sm" name="bulan">
										<option @if(date('m')=='01') selected @endif value="01">Januari</option>
										<option @if(date('m')=='02') selected @endif value="02">Februari</option>
										<option @if(date('m')=='03') selected @endif value="03">Maret</option>
										<option @if(date('m')=='04') selected @endif value="04">April</option>
										<option @if(date('m')=='05') selected @endif value="05">Mei</option>
										<option @if(date('m')=='06') selected @endif value="06">Juni</option>
										<option @if(date('m')=='07') selected @endif value="07">Juli</option>
										<option @if(date('m')=='08') selected @endif value="08">Agustus</option>
										<option @if(date('m')=='09') selected @endif value="09">September</option>
										<option @if(date('m')=='10') selected @endif value="10">Oktober</option>
										<option @if(date('m')=='11') selected @endif value="11">November</option>
										<option @if(date('m')=='12') selected @endif value="12">Desember</option>
									</select>
								</div>
								<div class="col-sm-4 float-right">
									<button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			@if( session('msg') )
			<?php $msg = session('msg'); ?>
			<div class="alert alert-{{ $msg['type'] }} alert-remove">
				{!! $msg['text'] !!}
			</div>
			@endif
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="datatable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Sewa</th>
							<th class="text-center">Total Harga</th>
							<th class="text-center">Bukti Pembayaran</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if($records->count()>0)
						@foreach($records as $row)
						<tr>
							<td class="text-center">{{ $loop->iteration }}</td>
							<td>{{ $row->User->nama }} <br> {{ $row->User ? $row->User->nohp : '-' }}</td>
							<td class="text-left">
								<ul>
									@foreach($row->BookingDetail as $val)
									<li>
										<strong>{{ 'Rp. '.number_format($val->harga, 0,',','.') }}</strong> - ({{ $val->jumlah }} Produk)
										<br>
										{{ $val->Produk->nama }}
									</li>
									@endforeach
								</ul>
							</td>
							<td class="text-right">Rp. {{ number_format($row->total_harga, 0,',','.') }}</td>
							<td class="text-center">
								@if($row->bukti_pembayaran)
								<a href="{{ asset('storage/bukti/'.$row->bukti_pembayaran) }}" target="_blank"><img src="{{ asset('storage/bukti/'.$row->bukti_pembayaran) }}" width="80px;"></a>
								@endif
							</td>
							<td class="text-center" width="100px">
								@if($row->deleted_at == null)
								<button type="button" title="delete" onclick="willRemove('{{ $row->hashid }}','DELETE')" class="btn btn-danger btn-sm">
									<i class="fa fa-trash"></i>
								</button>
								<a href="{{ route('produk.edit', $row->hashid) }}" class="btn btn-success btn-sm">
									<i class="fas fa-pencil-alt" ></i>
								</a>
								@else
								<button type="button" class="btn btn-success btn-sm" onclick="restore('{{ $row->hashid }}')" title="Restore">
									<i class="fas fa-reply-all"></i>
								</button>
								<button type="button" title="destroy" onclick="willRemove('{{ $row->hashid }}','DESTROY')" class="btn btn-danger btn-sm">
									<i class="far fa-trash-alt"></i>
								</button>
								@endif
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<form id="action-form" action="" method="POST">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		<input type="hidden" name="id">
	</form>
	@endsection
	@section('scripts')
	<script src="{{ mix('/js/sweetalert.js') }}"></script>
	<script src="{{ mix('/js/datatable.js') }}"></script>
	<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#datatable').DataTable();
		});

		function execRemove(method, hashid) {
			$("#action-form").attr('action', 'booking/delete/' + hashid);
			$("#action-form input[name=_method]").val(method);
			$("#action-form").submit();
		}

		function willRemove(id, method) {
			swal({
				title: "Apakah Anda Yakin?",
				text: "anda yakin menghapus data ini?",
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

		function restore (hashid) {
			$("#action-form").attr('action', 'booking/restore/' + hashid);
			$("#action-form input[name=_method]").val("POST");
			$("#action-form").submit();
		};

		Pusher.logToConsole = true;
		<?php $pusherkey = env('PUSHER_APP_KEY',false); ?>

		var pusher = new Pusher('a1fe9e7230414caaa312', {
			cluster: 'ap1'
		});

		var channel = pusher.subscribe('my-channel');
		channel.bind('my-event', function(data) {
			if (data.message=="ok") 
			{
				window.location.href="{{ route('dashboard') }}";
			}
		});

	</script>
	@endsection
