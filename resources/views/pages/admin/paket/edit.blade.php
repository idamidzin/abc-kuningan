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
					Edit Paket
					<div class="float-right">

					</div>
				</div>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.paket.update', $paket->hashid) }}" method="POST" enctype="multipart/form-data">
					@method('PUT')
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama Paket</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="nama" value="{{ old('nama') ? old('nama') : $paket->nama }}" placeholder="Masukan Nama Paket" />
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
							<input autofocus class="form-control" required type="number" name="jumlah_jam" value="{{ old('jumlah_jam') ? old('jumlah_jam') : $paket->jumlah_jam }}" placeholder="Masukan jumlah jam" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
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
							<input autofocus class="form-control" required type="number" name="jumlah_hari" value="{{ old('jumlah_hari') ? old('jumlah_hari') : $paket->jumlah_hari }}" placeholder="Masukan jumlah hari" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
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
								<option @if($paket->for_use == 'member') selected @endif value="member">Member</option>
								<option @if($paket->for_use == 'diklat') selected @endif value="diklat">Diklat</option>
								<option @if($paket->for_use == 'non-member') selected @endif value="non-member">Non Member</option>
							</select>
							@if ($errors->has('target'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('target') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Potongan Harga</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" type="text" name="diskon" value="{{ old('diskon') ? old('diskon') : $paket->diskon }}" placeholder="Masukan Potongan Harga" id="rupiah" onkeypress="return hanyaAngka(event)"/>
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
							<input autofocus class="form-control" required type="text" name="harga" value="{{ old('harga') ? old('harga') : $paket->harga }}" placeholder="Masukan Harga Paket" id="rupiah" onkeypress="return hanyaAngka(event)"/>
							@if ($errors->has('harga'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('harga') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Deskripsi</label>
						<div class="col-sm-7">
							<textarea name="deskripsi" id="deskripsi" placeholder="Tuliskan sesuatu disini..">{!! json_decode($paket->deskripsi) !!}</textarea>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-xl-12 text-center">
								<a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">Kembali</a>&nbsp;
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
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">

	ClassicEditor.create(document.querySelector('textarea#deskripsi'), {
		toolbar: {
			items: ['bold', 'italic', 'heading', '|', 'bulletedList', 'numberedList', '|', 'indent', 'outdent', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
		},
		language: 'id',
		table: {
			contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
		}
	})
	.then(function(editor) {
		window.editor = editor;
	})
	.catch(function(error) {
		console.error(error);
	});
</script>
@endsection
