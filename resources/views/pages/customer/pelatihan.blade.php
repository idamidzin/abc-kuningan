@extends('layouts.horizontal')
@section('content')

@include('layouts.particals.common-banner')

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
