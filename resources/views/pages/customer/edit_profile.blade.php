@extends('layouts.horizontal')
@section('content')

<div class="container mt-5 mb-5" style="margin-top: 150px !important;">
    <div class="billing_details mt-5">
        <div class="row">
            @if( session('msg') )
            <?php $msg = session('msg'); ?>
            <div class="col-sm-12">
                <div class="alert alert-{{ $msg['type'] }} alert-remove">
                    {!! $msg['text'] !!}
                </div>
            </div>
            @endif
            <div class="col-lg-12">
                <form class="row contact_form card card-body" enctype="multipart/form-data" action="{{ route('profile.update', auth()->user()->hashid) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group p_star">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') ? old('nama') : auth()->user()->nama_lengkap }}">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') ? old('email') : auth()->user()->email }}">
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="from-control country_select">
                                <option @if(auth()->user()->jenis_kelamin == "L") selected @endif value="L">Laki-laki</option>
                                <option @if(auth()->user()->jenis_kelamin == "P") selected @endif value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label>No Hp</label>
                            <input type="number" name="nohp" class="form-control" value="{{ old('nohp') ? old('nohp') : auth()->user()->nohp }}">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : auth()->user()->tanggal_lahir }}">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label>
                                Kartu Keluarga/KTP &nbsp;&nbsp;
                                @if(auth()->user()->kk_ktp)
                                <a target="_blank" href="{{ asset('storage/profile/'.auth()->user()->kk_ktp) }}" class="img-pop-up">Lihat</a>
                                @endif
                            </label>
                            <input type="file" name="kk_ktp" class="form-control" value="{{ old('kk_ktp') ? old('kk_ktp') : auth()->user()->kk_ktp }}">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label>
                                Foto Pribadi &nbsp;&nbsp;
                                @if(auth()->user()->foto)
                                <a target="_blank" href="{{ asset('storage/profile/'.auth()->user()->foto) }}" class="img-pop-up">Lihat</a>
                                @endif
                            </label>
                            <input type="file" name="foto" class="form-control" value="{{ old('foto') ? old('foto') : auth()->user()->foto }}">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat">{{ old('alamat') ? old('alamat') : auth()->user()->alamat }}</textarea>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <label><h5>Akun</h5></label>
                            <div class="row">
                                <div class="col-md-12 form-group p_star">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ old('username') ? old('username') : auth()->user()->username }}">
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Masukan password baru">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <button class="genric-btn primary default mt-2">Simpan perubahan</button>
                            <a href="{{ route('profile') }}" class="genric-btn success default ml-2">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
</script>
@endsection
