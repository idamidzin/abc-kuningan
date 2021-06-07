<!DOCTYPE html>
<html lang="en">
<head>
    <title>Anrimusthi Badminton Centre Kuningan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('images/badminton.png') }}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" data-rtl="{{ asset('css/bootstrap-rtl.css') }}" id="bscss" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('login_template/css/login_admin.css') }}">
    <!--===============================================================================================-->
</head>
<body>

    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="{{ asset('images/badminton.png') }}" alt=""/>
                <h3>Selamat Datang</h3>
                <p>Halaman Masuk Administrator Anrimusthi Badminton Centre Kuningan</p>
            </div>
            <div class="col-md-9 register-right">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h6 class="register-heading">Silahkan masuk untuk melanjutkan</h6>
                        <form action="{{ route('login.proses') }}" method="POST">
                            @csrf
                            <div class="row register-form">
                                <div class="col-md-6 offset-3">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="Username*">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password*">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>                                          

    <!--===============================================================================================-->
    <script src="{{ asset('login_template(vendor/jquery/jquery-3.2.1.min.js') }}"></script>

</body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        if ($(".alert-remove").length > 0) {
            let delay = $(".alert-remove").data('delay',false);
            $(".alert-remove").delay(delay !== false ? delay : 2000).slideUp(500);
        }
    })
</script>
