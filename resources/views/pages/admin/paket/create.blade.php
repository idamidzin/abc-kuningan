@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Paket
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-8 offset-md-2">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Tambah Paket
					<div class="float-right">

					</div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama Paket</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukan Nama Paket" />
							@if ($errors->has('nama'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nama') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Jumlah Jam</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="number" name="jumlah_jam" value="{{ old('jumlah_jam') }}" placeholder="Masukan jumlah jam" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
							@if ($errors->has('jumlah_jam'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('jumlah_jam') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Jumlah Hari</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="number" name="jumlah_hari" value="{{ old('jumlah_hari') }}" placeholder="Masukan jumlah hari" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
							@if ($errors->has('jumlah_hari'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('jumlah_hari') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Target</label>
						<div class="col-sm-7">
							<select name="target" class="form-control" required>
								<option value="member">Member</option>
								<option value="non-member">Non Member</option>
							</select>
							@if ($errors->has('target'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('target') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Diskon</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="diskon" value="{{ old('diskon') }}" placeholder="Masukan Harga Diskon" id="rupiah" onkeypress="return hanyaAngka(event)"/>
							@if ($errors->has('diskon'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('diskon') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Harga</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="harga" value="{{ old('harga') }}" placeholder="Masukan Harga Paket" id="rupiah" onkeypress="return hanyaAngka(event)"/>
							@if ($errors->has('harga'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('harga') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-xl-12 text-center">
								<a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">Kembali</a>&nbsp;
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
