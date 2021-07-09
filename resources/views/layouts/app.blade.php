<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Bootstrap Admin App" />
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/badminton.png') }}" />

    <title>Anrimusthi Badminton Centre Kuningan</title>

    <!-- =============== VENDOR STYLES ===============-->
    <link rel="stylesheet" href="{{ mix('/css/vendor.css') }}" />
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="{{ mix('/css/bootstrap.css') }}" data-rtl="{{ mix('/css/bootstrap-rtl.css') }}" id="bscss" />
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" data-rtl="{{ mix('/css/app-rtl.css') }}" id="maincss" />
    @yield('styles')
    <link rel="stylesheet" href="{{ mix('/css/theme-c.css') }}">
  </head>

  <body>
    <div class="wrapper">
      <!-- top navbar-->
      @include('layouts.includes.header')
      <!-- sidebar-->
      @include('layouts.includes.sidebar')
      <!-- offsidebar-->
      @include('layouts.includes.offsidebar')
      <!-- Main section-->
      <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">
          @yield('content')
        </div>
      </section>
      <!-- Page footer-->
      @include('layouts.includes.footer')
    </div>
    @yield('body-area')
    <!-- =============== VENDOR SCRIPTS ===============-->
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <!-- =============== APP SCRIPTS ===============-->
    <script src="{{ mix('/js/app.js') }}"></script>
    <!-- =============== CUSTOM PAGE SCRIPTS ===============-->
    @yield('scripts')
    <script type="text/javascript">
      $(document).ready(function(){
        if ($(".alert-remove").length > 0) {
          let delay = $(".alert-remove").data('delay');
          setTimeout(function(){
            $(".alert-remove").slideUp(500);
          },typeof delay !== 'undefined' ? parseInt(delay) : 6000);
        }

      });

      function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57))

        return false;
      return true;
    }

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : '');
    }
    </script>
  </body>
</html>
