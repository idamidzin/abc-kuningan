@extends('layouts.horizontal')
@section('content')

@section('scripts')
<link href="{{ asset('assets/packages/core/main.css') }}" rel='stylesheet' />
<link href="{{ asset('assets/packages/daygrid/main.css') }}" rel='stylesheet' />
<script src="{{ asset('assets/packages/core/main.js') }}"></script>
<link href="{{ asset('assets/packages/list/main.css') }}" rel='stylesheet' />
<script src="{{ asset('assets/packages/interaction/main.js') }}"></script>
<script src="{{ asset('assets/packages/daygrid/main.js') }}"></script>
<script src="{{ asset('assets/packages/core/locales-all.js') }}"></script>
<script src="{{ asset('assets/packages/list/main.js') }}"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid','list' ],
            header: {
                left: 'prevYear, prev, next, nextYear today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay,listMonth'
            },
            defaultDate: '{{ $tgl_default }}',
            locale: 'id',
            allDaySlot: false,
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            eventTextColor: "white",
            events: [
                @foreach($data_member as $row)
                {
                    title : '{{ $row->title }}',
                    start : '{{ $row->start }}',
                    end : '{{ $row->start }}',
                },
                @endforeach
                @foreach($data_booking as $row)
                {
                    title : '{{ $row->title }}',
                    start : '{{ $row->start }}',
                    end : '{{ $row->start }}',
                },
                @endforeach
                {
                    title:'{{ "Pelatihan Diklat" }} \n08:00sd12:00\nSemua Lapang',
                    daysOfWeek: [ '0' ],
                },
            ]
        });
        calendar.render();
    });

</script>
<style>

    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }

    .fc-list-item-time {
        display:none;
    }

</style>
@endsection

@include('layouts.particals.common-banner')

<div id='calendar' class="mt-5"></div>

<!--================Single Product Area =================-->
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 mb-2">
            <h4>Jadwal Pelatihan (Diklat)</h4>
        </div>
        @foreach($jadwal as $row)
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $row->Lapang->nama }}</h5>
                    <i>{{ $row->Kategori->nama }}</i><br>
                    Setiap hari <h5 class="d-inline"><strong style="color: #6a4698;">{{ ucwords($row->hari) }}</strong></h5><br>
                    Jam {{ date('H:i', strtotime($row->jam_mulai)) }} - {{ date('H:i', strtotime($row->jam_selesai)) }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 mb-2">
            <h4>Jadwal Member</h4>
        </div>
        @if(count($member) > 0)
        @foreach($member as $row)
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $row->Lapang->nama }}</h5>
                    <i>{{ $row->User->nama_lengkap }} {{ $row->nama_group ? '('.$row->nama_group.')' : '' }}</i><br>
                    <br>
                    {{ rangeDate($row->tanggal_mulai, $row->tanggal_selesai) }} <br>
                    Setiap : <br> 
                    <b>{{ ucwords($row->hari) }}</b>, {{ date('H:i', strtotime($row->jam_mulai)) }} - {{ date('H:i', strtotime($row->jam_selesai)) }}
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-sm-12 mb-2">
            <div class="alert alert-danger">Jadwal untuk member masih kosong !</div>
        </div>
        @endif
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 mb-2">
            <h4>Jadwal Booking</h4>
        </div>
        @if(count($booking) > 0)
        @foreach($booking as $row)
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $row->Lapang->nama }}</h5>
                    <i>{{ $row->User->nama_lengkap }} {{ $row->nama_group ? '('.$row->nama_group.')' : '' }}</i><br>
                    <br>
                    {{ rangeDate($row->tanggal_mulai, $row->tanggal_selesai) }} <br>
                    <b>{{ ucwords($row->hari) }}</b>, Jam {{ date('H:i', strtotime($row->jam_mulai)) }} - {{ date('H:i', strtotime($row->jam_selesai)) }}
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-sm-12 mb-2">
            <div class="alert alert-danger">Jadwal untuk booking lapangan masih kosong !</div>
        </div>
        @endif
    </div>
</div>
<!--================End Single Product Area =================-->
<br><br><br>
@endsection
@section('scripts')
<script src="{{ mix('/js/sparkline.js') }}"></script>
<script src="{{ mix('/js/easypiechart.js') }}"></script>
<script src="{{ mix('/js/flot.js') }}"></script>
<script src="{{ mix('/js/sweetalert.js') }}"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript">
</script>
@endsection
