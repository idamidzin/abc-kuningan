@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Kategori
	</div>
</div>
<div class="container-fluid">
	<!-- DATATABLE DEMO 1-->
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<a href="{{ route('admin.kategori.index') }}" class="{{ $is_trash ? 'text-success':'text-muted' }}"> Semua
					<span class="badge badge-pill badge-info">{{ $kategori_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('admin.kategori.index') }}?status=trash" class="{{ $is_trash ? 'text-muted':'text-danger' }}">
					Sampah
					<span class="badge badge-pill badge-danger">{{ $trash_count }}</span>
				</a>
				<div class="float-right">
					<a href="{{ route('admin.kategori.create') }}" class="btn btn-purple">Data Baru</a>
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
							<th class="text-center">Usia</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if($records->count()>0)
						@foreach($records as $row)
						<tr>
							<td class="text-center" width="5%">{{ $loop->iteration }}</td>
							<td>{{ $row->nama }}</td>
							<td class="text-center">{{ $row->usia_mulai }} - {{ $row->usia_sampai }}</td>
							<td class="text-center" width="100px">
								@if($row->deleted_at == null)
								<button type="button" title="delete" onclick="willRemove('{{ $row->hashid }}','DELETE')" class="btn btn-danger btn-sm">
									<i class="fa fa-trash"></i>
								</button>
								<a href="{{ route('admin.kategori.edit', $row->hashid) }}" class="btn btn-success btn-sm">
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
	<script type="text/javascript">
		$(document).ready(function(){
			$('#datatable').DataTable();
		});

		function execRemove(method, hashid) {
			$("#action-form").attr('action', 'kategori/delete/' + hashid);
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
			$("#action-form").attr('action', 'kategori/restore/' + hashid);
			$("#action-form input[name=_method]").val("POST");
			$("#action-form").submit();
		};
	</script>
	@endsection
