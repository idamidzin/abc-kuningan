@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Member
	</div>
</div>
<div class="container-fluid">
	<!-- DATATABLE DEMO 1-->
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="row">
					<div class="col-sm-12">
						<a href="{{ route('admin.member.index') }}?status=baru&bulan={{ $bulan }}&tahun={{ $tahun }}" class="{{ $status == 'baru' || $status == '' ? 'text-muted':'text-primary' }}"> Member Baru
							<span class="badge badge-pill {{ $status == 'baru' || $status == '' ? 'badge-primary' : 'bg-gray' }}">{{ $member_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('admin.member.index') }}?status=terima&bulan={{ $bulan }}&tahun={{ $tahun }}" class="{{ $status == 'terima' ? 'text-muted':'text-warning' }}">
							Member Terima
							<span class="badge badge-pill {{ $status == 'terima' ? 'badge-warning' : 'bg-gray' }}">{{ $terima_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('admin.member.index') }}?status=selesai&bulan={{ $bulan }}&tahun={{ $tahun }}" class="{{ $status == 'selesai' ? 'text-muted':'text-success' }}">
							Member Selesai
							<span class="badge badge-pill {{ $status == 'selesai' ? 'badge-success' : 'bg-gray' }}">{{ $selesai_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('admin.member.index') }}?status=cancel&bulan={{ $bulan }}&tahun={{ $tahun }}" class="{{ $status == 'cancel' ? 'text-muted':'text-purple' }}">
							Cancel
							<span class="badge badge-pill {{ $status == 'cancel' ? 'badge-purple' : 'bg-gray' }}">{{ $cancel_count }}</span>
						</a>
						&nbsp; | &nbsp;
						<a href="{{ route('admin.member.index') }}?status=trash&bulan={{ $bulan }}&tahun={{ $tahun }}" class="{{ $status == 'trash' ? 'text-muted':'text-danger' }}">
							Sampah
							<span class="badge badge-pill {{ $status == 'trash' ? 'badge-danger' : 'bg-gray' }}">{{ $trash_count }}</span>
						</a>
					</div>
					<div class="col-sm-4 d-block mt-3">
						<form action="" method="GET">
							<input type="hidden" name="status" value="{{ $status }}">
							<div class="row">
								<div class="col-sm-4">
									<select class="custom-select custom-select-sm" name="bulan">
										<option @if($bulan=='01') selected @endif value="01">Januari</option>
										<option @if($bulan=='02') selected @endif value="02">Februari</option>
										<option @if($bulan=='03') selected @endif value="03">Maret</option>
										<option @if($bulan=='04') selected @endif value="04">April</option>
										<option @if($bulan=='05') selected @endif value="05">Mei</option>
										<option @if($bulan=='06') selected @endif value="06">Juni</option>
										<option @if($bulan=='07') selected @endif value="07">Juli</option>
										<option @if($bulan=='08') selected @endif value="08">Agustus</option>
										<option @if($bulan=='09') selected @endif value="09">September</option>
										<option @if($bulan=='10') selected @endif value="10">Oktober</option>
										<option @if($bulan=='11') selected @endif value="11">November</option>
										<option @if($bulan=='12') selected @endif value="12">Desember</option>
									</select>
								</div>
								<div class="col-sm-4">
									<select name="tahun" size="1" class="form-control">
										<option value="">--Pilih Tahun--</option>
										<?php
										$tgl_akhir= date('Y')+3;
										for($i=$tgl_akhir; $i>=date('Y'); $i-=1){
											echo "<option ".($tahun==$i?"selected":"")." value='$i'>$i</option>";
										}
										?>
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
							<th class="text-center">Tanggal Mulai</th>
							<th class="text-center">Lapang</th>
							<th class="text-center">Paket</th>
							<th class="text-center">Waktu</th>
							<th class="text-center">Bukti Pembayaran</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if($records->count()>0)
						@foreach($records as $row)
						<tr>
							<td class="text-center" width="5%">{{ $loop->iteration }}</td>
							<td>{{ $row->User->nama_lengkap }}</td>
							<td>{{ tanggalIndo($row->tanggal_mulai) }}</td>
							<td>{{ $row->Lapang->nama }}</td>
							<td>
								<strong>{{ $row->Paket->nama }}</strong> <br>
								<li>{{ menitKeJam($row->Paket->jumlah_jam*60).' Jam' }}</li>
								<li>{{ 'Rp. '.number_format($row->harga, 0,',','.') }}</li>
							</td>
							<td class="text-center">
								{{ date('H:i', strtotime($row->jam_mulai)) }} -
								{{ date('H:i', strtotime('+'.menitKeJam($row->Paket->jumlah_jam*60).' hours', strtotime($row->jam_mulai))) }}
							</td>
							<td class="text-center">
								@if($row->bukti_pembayaran)
									<a href="{{ asset('storage/bukti_pembayaran/'.$row->bukti_pembayaran) }}" target="_blank">
										<img src="{{ asset('storage/bukti_pembayaran/'.$row->bukti_pembayaran) }}" width="80px">
									</a>
								@else
								@endif
							</td>
							<td class="text-center" width="100px">
								@if($row->deleted_at == null)
									@if($row->status == 0)
									@if($row->bukti_pembayaran)
									<a href="{{ route('admin.member.proses', $row->hashid) }}?param=1" class="btn btn-primary btn-sm">
										Terima
									</a>
									<br>
									@endif
									<a href="{{ route('admin.member.proses', $row->hashid) }}?param=3" class="btn btn-danger btn-sm mt-1">
										Cancel
									</a>
									@elseif($row->status == 1)
									<a href="{{ route('admin.member.proses', $row->hashid) }}?param=2" class="btn btn-success btn-sm">
										Selesai
									</a>
									<br>
									@elseif($row->status == 2)
									<span class="badge badge-info">Selesai</span>
									@elseif($row->status == 3)
									<a href="{{ route('admin.member.proses', $row->hashid) }}?param=1" class="btn btn-primary btn-sm">
										Terima
									</a>
									<button type="button" title="delete" onclick="willRemove('{{ $row->hashid }}','DELETE')" class="btn btn-danger btn-sm">
										<i class="fa fa-trash"></i>
									</button>
									@endif
								@else
									<button type="button" class="btn btn-success btn-sm" onclick="restore('{{ $row->hashid }}')" title="Restore">
										<i class="fas fa-reply-all"></i>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('#datatable').DataTable();
		});

		function execRemove(method, hashid) {
			$("#action-form").attr('action', 'member/delete/' + hashid);
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
			$("#action-form").attr('action', 'member/restore/' + hashid);
			$("#action-form input[name=_method]").val("POST");
			$("#action-form").submit();
		};
	</script>
	@endsection
