@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Lapang
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-8 offset-md-2">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Tambah Lapang
					<div class="float-right">

					</div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.lapang.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukan Nama Lapang" />
							@if ($errors->has('nama'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nama') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Keterangan</label>
						<div class="col-sm-7">
							<textarea name="keterangan" class="form-control" placeholder="Masukan Keterangan">{{ old('keterangan') }}</textarea>
							@if ($errors->has('keterangan'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('keterangan') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Foto</label>
						<div class="col-sm-7">
							<input type="file" name="foto" class="form-control" required>
							@if ($errors->has('foto'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('foto') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-xl-12 text-center">
								<a href="{{ route('admin.lapang.index') }}" class="btn btn-secondary">Kembali</a>&nbsp;
								<button class="btn btn-primary mb-2 mt-2" type="submit">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

@endsection
@section('scripts')
@endsection
