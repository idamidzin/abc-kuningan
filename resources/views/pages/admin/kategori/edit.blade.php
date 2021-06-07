@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Kategori
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-8 offset-md-2">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Edit Kategori
					<div class="float-right">

					</div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.kategori.update', $kategori->hashid) }}" method="POST">
					@method('PUT')
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="nama" value="{{ old('nama') ? old('nama') : $kategori->nama }}" placeholder="Masukan Nama Kategori" />
							@if ($errors->has('nama'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nama') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Usia Mulai</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="number" name="usia_mulai" value="{{ old('usia_mulai') ? old('usia_mulai') : $kategori->usia_mulai }}" placeholder="Usia kategori mulai dari ?" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
							@if ($errors->has('usia_mulai'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('usia_mulai') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Usia Sampai</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="number" name="usia_sampai" value="{{ old('usia_sampai') ? old('usia_sampai') : $kategori->usia_sampai }}" placeholder="Usia kategori sampai ?" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
							@if ($errors->has('usia_sampai'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('usia_sampai') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-xl-12 text-center">
								<a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>&nbsp;
								<button class="btn btn-primary mb-2 mt-2" type="submit">Simpan Perubahan</button>
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
