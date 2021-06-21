@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.common-banner')
<!--================Single Product Area =================-->
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="order_box mt-5">
                <h2>Beli Paket</h2>
                <ul class="list">
                    <li>
                        <a href="#">Checkout <span>Rincian</span></a>
                    </li>
                    @if($paket->for_use == 'diklat')
                    <li>
                        <a href="#">
                            {{ $paket->nama }} (Pendaftaran)
                            <span class="last"><strong>{{'Rp. '.number_format($paket->harga-$paket->diskon, 0,',','.')}}</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Perbulan
                            <span class="last"><strong>@rupiah($paket->harga_perbulan)</strong></span>
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="#">
                            {{ $paket->nama }}
                            <span class="last"><strong>{{'Rp. '.number_format($paket->harga-$paket->diskon, 0,',','.')}}</strong></span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="#">
                            Diskon
                            <span class="last">{{ $paket->diskon ? $paket->diskon : '-' }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Durasi Waktu
                            <span class="last">{{ $paket->jumlah_jam.' Menit'  }}</span>
                        </a>
                    </li>
                    @if($paket->for_use != 'non-member')
                    <li>
                        <a href="#">
                            Jangka
                            <span class="last">{{ $paket->jumlah_hari/30 }} Bulan</span>
                        </a>
                    </li>
                    @endif
                </ul>
                <!-- <ul class="list list_2">
                    <li>
                        <a href="#">
                            Total
                            <span>{{'Rp. '.number_format($paket->harga-$paket->diskon, 0,',','.')}}</span>
                        </a>
                    </li>
                </ul> -->
            </div>
        </div>
        <div class="col-lg-7">
            <div class="billing_details mt-5">
                <div class="row">
                    <div class="col-lg-12">
                        @if($paket->for_use == 'member')
                        <h3>Silahkan untuk mengisi dan cek jadwal yang tersedia</h3>
                        <form class="row contact_form" action="{{ route('booking') }}" method="POST">
                            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                            @csrf
                            <div class="col-md-12 form-group p_star">
                                <label><strong>Lapangan</strong></label>
                                <select name="lapang_id" class="from-control country_select" id="lapang_id">
                                    <option value="">Pilih Lapangan</option>
                                    @foreach($lapang as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <label><strong>Setiap hari apa ?</strong></label>
                                <select name="hari" class="from-control country_select" id="hari">
                                    <option value="">Pilih Hari</option>
                                    <option value="1">Senin</option>
                                    <option value="2">Selasa</option>
                                    <option value="3">Rabu</option>
                                    <option value="4">Kamis</option>
                                    <option value="5">Jumat</option>
                                    <option value="6">Sabtu</option>
                                    <option value="7">Minggu</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <label><strong>Berapa lama (bulan) ?</strong></label>
                                <input type="number" class="form-control" id="jumlah_bulan" name="jumlah_bulan" min="1" value="{{ old('jumlah_bulan') ? old('jumlah_bulan') : '1' }}">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Setiap jam berapa ?</strong></label>
                                <input type="time" class="form-control" id="start_time" name="start_time">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Sampai jam ?</strong></label>
                                <input type="time" class="form-control" id="end_time" name="end_time" readonly>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Akan dimulai pada tanggal ?</strong></label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Berakhir pada tanggal ?</strong></label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" readonly>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <label><strong>Total Bayar ?</strong></label>
                                <input type="text" class="form-control" id="total_bayar_member" name="total_bayar" readonly>
                            </div>
                            <div class="col-md-12 form-group p_star" style="display: none;" id="alert">
                                <div class="alert alert-danger">Jadwal tersebut sudah terpakai, silahkan untuk mencari jadwal yang kosong</div>
                            </div>
                            <div class="col-md-12 form-group p_star" style="display: none;" id="ajukan">
                                <button class="primary-btn" type="submit">Ajukan Member</button>
                            </div>
                        </form>
                        @elseif($paket->for_use == 'diklat')
                        <form class="row contact_form" action="{{ route('booking') }}" method="POST">
                            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                            @csrf
                            <div class="col-md-12 form-group p_star">
                                <label><strong>Kategori</strong></label>
                                <select name="jadwal_id" class="from-control country_select" id="jadwal_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($jadwal as $row)
                                    <option value="{{ $row->id }}">{{ $row->Kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Setiap jam berapa ?</strong></label>
                                <input type="time" class="form-control" id="jam_mulai_diklat" name="start_time" readonly>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Sampai jam ?</strong></label>
                                <input type="time" class="form-control" id="jam_selesai_diklat" name="end_time" readonly>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Lapangan ?</strong></label>
                                <input type="text" class="form-control" id="lapang_diklat" name="lapangan" readonly>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Berapa lama (bulan) ?</strong></label>
                                <input type="number" class="form-control" id="jumlah_bulan_diklat" name="jumlah_bulan" min="1" value="{{ old('jumlah_bulan') ? old('jumlah_bulan') : '1' }}">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Setiap Hari ?</strong></label>
                                <input type="text" class="form-control" id="hari_diklat" name="hari" readonly>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Total Bayar ?</strong></label>
                                <input type="text" class="form-control" id="total_bayar" name="total_bayar" readonly>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Akan dimulai pada tanggal ?</strong></label>
                                <input type="date" class="form-control" id="tanggal_mulai_diklat" name="tanggal_mulai" required>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Berakhir pada tanggal ?</strong></label>
                                <input type="date" class="form-control" id="tanggal_selesai_diklat" name="tanggal_selesai" readonly>
                            </div>
                            <div class="col-md-12 form-group p_star" style="display: none;" id="informasi_diklat_sudah">
                                <div class="alert alert-info">Anda sudah pernah bergabung dengan diklat kami, silahkan untuk melakukan pembayaran perbulannya saja</div>
                            </div>
                            <div class="col-md-12 form-group p_star" style="display: none;" id="informasi_diklat_belum">
                                <div class="alert alert-warning">Anda belum pernah bergabung dengan diklat kami, silahkan untuk melakukan pembayaran pendaftaran (@rupiah($paket->harga))</div>
                            </div>
                            <div class="col-md-12 form-group p_star" style="display: none;" id="ajukan_diklat">
                                <button class="primary-btn" type="submit">Bergabung Perlatihan</button>
                            </div>
                        </form>
                        @else
                        <h3>Silahkan untuk mengisi dan cek jadwal yang tersedia</h3>
                        <form class="row contact_form" action="{{ route('booking') }}" method="POST">
                            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                            @csrf
                            <div class="col-md-12 form-group p_star">
                                <label><strong>Lapangan</strong></label>
                                <select name="lapang_id" class="from-control country_select" id="lapang_id_booking">
                                    <option value="">Pilih Lapangan</option>
                                    @foreach($lapang as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <label><strong>Tanggal berapa ?</strong></label>
                                <input type="date" class="form-control" id="tanggal_mulai_booking" name="tanggal_mulai">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Mau jam berapa ?</strong></label>
                                <input type="time" class="form-control" id="start_time_booking" name="start_time">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label><strong>Sampai jam ?</strong></label>
                                <input type="time" class="form-control" id="end_time_booking" name="end_time" readonly>
                            </div>
                            <div class="col-md-12 form-group p_star" style="display: none;" id="alert_booking">
                                <div class="alert alert-danger">Jadwal tersebut sudah terpakai, silahkan untuk mencari jadwal yang kosong</div>
                            </div>
                            <div class="col-md-12 form-group p_star" style="display: none;" id="ajukan_booking">
                                <button class="primary-btn" type="submit">Ajukan Booking</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->
<br><br><br>
@endsection
@section('scripts')
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">

    // ========================== JS Untuk Booking ======================== //
    $(document).on('change','#start_time_booking', function() {
        if ($('#lapang_id_booking').val() && $('#start_time_booking').val()) {
            $.get("{{ route('ketersediaan-booking') }}",{
                start_time:$('#start_time_booking').val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari_booking').val(),
                lapang_id:$('#lapang_id_booking').val(),
                tanggal_mulai:$('#tanggal_mulai_booking').val()
            },function(res){
                console.log('res', res);
                document.getElementById("end_time_booking").value = res.end_time;
                if (res.status == true) {
                    $('#alert_booking').show();
                    $('#ajukan_booking').hide();
                }else{
                    if ($('#start_time_booking').val() && $('#lapang_id_booking').val() && $('#tanggal_mulai_booking').val()) {
                        $('#ajukan_booking').show();
                    }
                    $('#alert_booking').hide();
                }
            },'json');
        }
    });

    $(document).on('change','#lapang_id_booking', function() {
        if ($('#lapang_id_booking').val() && $('#start_time_booking').val() && $('#tanggal_mulai_booking').val()) {
            $.get("{{ route('ketersediaan-booking') }}",{
                start_time:$('#start_time_booking').val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari_booking').val(),
                lapang_id:$('#lapang_id_booking').val(),
                tanggal_mulai:$('#tanggal_mulai_booking').val()
            },function(res){
                console.log('res', res);
                document.getElementById("end_time_booking").value = res.end_time;
                if (res.status == true) {
                    $('#alert_booking').show();
                    $('#ajukan_booking').hide();
                }else{
                    if ($('#start_time_booking').val() && $('#lapang_id_booking').val() && $('#tanggal_mulai_booking').val()) {
                        $('#ajukan_booking').show();
                    }
                    $('#alert_booking').hide();
                }
            },'json');
        }
    });

    $(document).on('change','#tanggal_mulai_booking', function() {
        if ($('#lapang_id_booking').val() && $('#start_time_booking').val() && $('#tanggal_mulai_booking').val()) {
            $.get("{{ route('ketersediaan-booking') }}",{
                start_time:$('#start_time_booking').val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari_booking').val(),
                lapang_id:$('#lapang_id_booking').val(),
                tanggal_mulai:$('#tanggal_mulai_booking').val()
            },function(res){
                console.log('res', res);
                document.getElementById("end_time_booking").value = res.end_time;
                if (res.status == true) {
                    $('#alert_booking').show();
                    $('#ajukan_booking').hide();
                }else{
                    if ($('#start_time_booking').val() && $('#lapang_id_booking').val() && $('#tanggal_mulai_booking').val()) {
                        $('#ajukan_booking').show();
                    }
                    $('#alert_booking').hide();
                }
            },'json');
        }
    });
    // ========================== JS Untuk Booking ======================== //


    // ========================== JS Untuk Member ======================== //
    $(document).on('change','#start_time', function() {
        if ($('#lapang_id').val() && $('#hari').val()) {
            $.get("{{ route('get-end-time') }}",{
                start_time:$(this).val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari').val(),
                lapang_id:$('#lapang_id').val(),
                jumlah_bulan:$('#jumlah_bulan').val(),
                tanggal_mulai:$('#tanggal_mulai').val()
            },function(res){
                console.log('res', res);
                document.getElementById("end_time").value = res.end_time;
                document.getElementById("total_bayar_member").value = res.total_bayar;
                if (res.status == true) {
                    $('#alert').show();
                    $('#ajukan').hide();
                }else{
                    if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val() && $('#jumlah_bulan').val()) {
                        $('#ajukan').show();
                    }
                    $('#alert').hide();
                }
            },'json');
        }
    });

    $(document).on('change','#hari', function() {
        if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val()) {
            $.get("{{ route('get-end-time') }}",{
                start_time:$('#start_time').val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari').val(), 
                lapang_id:$('#lapang_id').val(),
                jumlah_bulan:$('#jumlah_bulan').val(),
                tanggal_mulai:$('#tanggal_mulai').val()
            },function(res){
                console.log('res', res);
                if (res.status == true) {
                    $('#alert').show();
                    $('#ajukan').hide();
                }else{
                    if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val() && $('#jumlah_bulan').val()) {
                        $('#ajukan').show();
                    }
                    $('#alert').hide();
                }
            },'json');
        }
    });

    $(document).on('change','#jumlah_bulan', function() {
        if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val()) {
            $.get("{{ route('get-end-time') }}",{
                start_time:$('#start_time').val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari').val(), 
                lapang_id:$('#lapang_id').val(),
                jumlah_bulan:$('#jumlah_bulan').val(),
                tanggal_mulai:$('#tanggal_mulai').val()
            },function(res){
                console.log('res', res);
                document.getElementById("tanggal_selesai").value = res.end_date;
                document.getElementById("total_bayar_member").value = res.total_bayar;
                if (res.status == true) {
                    $('#alert').show();
                    $('#ajukan').hide();
                }else{
                    if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val() && $('#jumlah_bulan').val()) {
                        $('#ajukan').show();
                    }
                    $('#alert').hide();
                }
            },'json');
        }
    });

    $(document).on('change','#tanggal_mulai', function() {
        if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val()) {
            $.get("{{ route('get-end-time') }}",{
                start_time:$('#start_time').val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari').val(), 
                lapang_id:$('#lapang_id').val(),
                jumlah_bulan:$('#jumlah_bulan').val(),
                tanggal_mulai:$('#tanggal_mulai').val()
            },function(res){
                document.getElementById("tanggal_selesai").value = res.end_date;
                document.getElementById("total_bayar_member").value = res.total_bayar;
                if (res.status == true) {
                    $('#alert').show();
                    $('#ajukan').hide();
                }else{
                    if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val() && $('#jumlah_bulan').val()) {
                        $('#ajukan').show();
                    }
                    $('#alert').hide();
                }
            },'json');
        }
    });

    $(document).on('change','#lapang_id', function() {
        if ($('#start_time').val() && $('#hari').val() && $('#tanggal_mulai').val()) {
            $.get("{{ route('get-end-time') }}",{
                start_time:$('#start_time').val(),
                paket_id:'{{ $paket->id }}',
                hari:$('#hari').val(),
                lapang_id:$('#lapang_id').val(),
                jumlah_bulan:$('#jumlah_bulan').val(),
                tanggal_mulai:$('#tanggal_mulai').val()
            },function(res){
                console.log('res', res);
                if (res.status == true) {
                    $('#alert').show();
                    $('#ajukan').hide();
                }else{
                    if ($('#start_time').val() && $('#hari').val() && $('#lapang_id').val() && $('#tanggal_mulai').val() && $('#jumlah_bulan').val()) {
                        $('#ajukan').show();
                    }
                    $('#alert').hide();
                }
            },'json');
        }
    });

    // ========================== JS Untuk Member ======================== //

    // ========================== JS Untuk Diklat ======================== //
    $(document).on('change','#jadwal_id', function() {
        $.get("{{ route('get-jadwal') }}",{
            jadwal_id:$(this).val(),
            jumlah_bulan:$('#jumlah_bulan_diklat').val(),
            paket_id:'{{ $paket->id }}',
            tanggal_mulai:$('#tanggal_mulai_diklat').val()
        },function(res){
            console.log('res', res);
            document.getElementById("jam_mulai_diklat").value = res.jam_mulai;
            document.getElementById("jam_selesai_diklat").value = res.jam_selesai;
            document.getElementById("lapang_diklat").value = res.lapang;
            document.getElementById("hari_diklat").value = res.hari;
            document.getElementById("total_bayar").value = res.harga_perbulan;
            if ($('#tanggal_mulai_diklat').val()) {
                document.getElementById("tanggal_selesai_diklat").value = res.tanggal_selesai;
            }
            if (res.booking_sebelumnya == 'sudah') {
                $('#informasi_diklat_sudah').show();
                $('#informasi_diklat_belum').hide();
            }else{
                $('#informasi_diklat_sudah').hide();
                $('#informasi_diklat_belum').show();
            }
            if ($('#tanggal_mulai_diklat').val()) {
                $('#ajukan_diklat').show();
            }
        },'json');
        
    });

    $(document).on('change','#jumlah_bulan_diklat', function() {
        $.get("{{ route('get-jadwal') }}",{
            jadwal_id:$('#jadwal_id').val(),
            jumlah_bulan:$('#jumlah_bulan_diklat').val(),
            paket_id:'{{ $paket->id }}',
            tanggal_mulai:$('#tanggal_mulai_diklat').val()
        },function(res){
            console.log('res', res);
            document.getElementById("jam_mulai_diklat").value = res.jam_mulai;
            document.getElementById("jam_selesai_diklat").value = res.jam_selesai;
            document.getElementById("lapang_diklat").value = res.lapang;
            document.getElementById("hari_diklat").value = res.hari;
            document.getElementById("total_bayar").value = res.harga_perbulan;
            if ($('#tanggal_mulai_diklat').val()) {
                document.getElementById("tanggal_selesai_diklat").value = res.tanggal_selesai;
            }
            if (res.booking_sebelumnya == 'sudah') {
                $('#informasi_diklat_sudah').show();
                $('#informasi_diklat_belum').hide();
            }else{
                $('#informasi_diklat_sudah').hide();
                $('#informasi_diklat_belum').show();
            }
            if ($('#tanggal_mulai_diklat').val()) {
                $('#ajukan_diklat').show();
            }
        },'json');
        
    });

    $(document).on('change','#tanggal_mulai_diklat', function() {
        $.get("{{ route('cek-tanggal-berakhir-diklat') }}",{
            jumlah_bulan:$('#jumlah_bulan_diklat').val(),
            tanggal_mulai:$(this).val(),
        },function(res){
            console.log('res', res);
            document.getElementById("tanggal_selesai_diklat").value = res.tanggal_selesai;
            if ($('#tanggal_mulai_diklat').val() && $('#jadwal_id').val()) {
                $('#ajukan_diklat').show();
            }
        },'json');
        
    });

</script>
@endsection
