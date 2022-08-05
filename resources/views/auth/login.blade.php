<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}img/favicon.png">
    <title>Login - Hanura</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />

<!-- font awesome  -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
</head>

<!--<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page"-->
<!--    style="  background-position: center;-->
<!--  background-repeat: no-repeat;-->
<!--  background-size: cover;background-image:url('https://asset.kompas.com/crops/KuUPVkChiwRY3nqGFJQ_f5x21vI=/0x0:999x666/750x500/data/photo/2020/01/24/5e2b0bfe32164.jpg')">-->
<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page"
    style="  background-position: center;
  background-repeat: no-repeat;
  background-size: cover; background-image:url('https://i.postimg.cc/P5pFtdSS/Latar-Loginpage.png');">
    <div class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card-group">
                        <div class="card p-4" style="opacity:0.8">
                            <div class="card-body">
                                @if(\Session::has('message'))
                                <p class="alert alert-info">
                                    {{ \Session::get('message') }}
                                </p>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}
                                    <h1>
                                        <div class="login-logo text-center">
                                            <a href="#">
                                                {{-- <img src="{{ asset('images/config/'.@unserialize(\App\Configuration::where('name','logo_login')->first()->value)) }}"
                                                --}}
                                                <img src="{{ url('/img/login page.png ') }}" width=200
                                                    style="margin-left:0;"> <br>

                                            </a>
                                            <p class="text-center"
                                                style="font-size:20px; font-weight:bold; font-family: 'Lato', sans-serif;">
                                                Sistem Informasi Anggota & Pengurus (SIAP) <br>Partai Hanura </p>
                                        </div>
                                    </h1>
                                    <p class="text-muted">Login</p>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input name="username" type="text"
                                            class="form-control @if($errors->has('username')) is-invalid @endif"
                                            placeholder="username">
                                        @if($errors->has('username'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('username') }}
                                        </em>
                                        @endif
                                    </div>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input name="password" type="password" id="password"
                                            class="form-control @if($errors->has('password')) is-invalid @endif"
                                            placeholder="password">
                                        @if($errors->has('password'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </em>
                                        @endif
                                      <div class="input-group-append">
                                            <span class="input-group-text" onclick="password_show_hide();">
                                                <i class="fas fa-eye d-none" id="show_eye"></i>
                                                 <i class="fas fa-eye-slash" id="hide_eye"></i>
                                            </span>
                                        </div>

                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-sm-6 col-sg-6 m-b-6">
                                            <input name="remember" type="checkbox" /> <label
                                                style="font-size:14px;">Ingat Saya </label>
                                                
                                                
                                            
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-sg-12 m-b-12 m-t-12">
                                            <input type="submit" class="btn btn-warning px-4" value='Login'>
                                            
                                             <a href="https://siap.partaihanura.or.id/uploads/aplikasi/hanura_mobile_21062022.apk" class="btn btn-success">
                                                Hanura Mobile  </a>  
                                                
                                                
                                             <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tutorial</button>
                                             <div class="dropdown-menu">
                                             <a class="dropdown-item" href="https://youtu.be/OItm7clUk2E" target="_blank">Input Data di Web (Video)</a>
                                             
                                             <a class="dropdown-item" href="https://youtu.be/qBCczVRmRFk
                                            "target="_blank">Hanura Mobile (Video)</a>                                                 
                                            <a class="dropdown-item" href="https://pdfhost.io/v/TPXbKBdq4_Sistem_informasi_keanggotaan_DPCTanpa_Video_compressed">Modul Petunjuk SIAP Untuk DPC (Pdf)</a>
                                            
                                            
                                            
                                       
                                             </div>    
                                            
                                            
                                        </div>
                                        
                                        <div class="col-sm-3 col-sg-3 m-b-3 m-t-3">
                                          
                                            
                                            
                                        </div>
                                        
                                        &nbsp; &nbsp;&nbsp;&nbsp;
                                        <div class="col-sm-3 col-sg-3 m-b-3 m-t-3">
                                       
                                        
                                        
                                        
                                        </div>
                                        
                                        
                                        
                                            
                                <!--  /www/wwwroot/hanura.net/uploads/aplikasi/hanura mobile.apk      <div class="col-sm-3 col-sg-3 m-b-3 m-t-3">-->
                                <!--             @if (Route::has('password.request'))--> 
                                <!--<a class="btn btn-link btn-success" style="color:white;" href="{{ asset('/uploads/aplikasi/hanura mobile.apk') }}">-->
                                <!--   Hanura Mobile-->
                                <!--</a>-->
                                <!--@endif-->
                                <!--        </div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function password_show_hide() {
            var x = document.getElementById("password");
            var show_eye = document.getElementById("show_eye");
            var hide_eye = document.getElementById("hide_eye");
         
            show_eye.classList.remove("d-none");
            if (x.type === "password") {
                x.type = "text";
                hide_eye.style.display = "none";
                show_eye.style.display = "block";
            } else {
                x.type = "password";
                hide_eye.style.display = "block";
                show_eye.style.display = "none";
            }
        }
    </script>
    <script src="{{ asset('/') }}js/jquery-3.2.1.min.js"></script>
    <script src="{{ asset('/') }}js/popper.min.js"></script>
    <script src="{{ asset('/') }}js/bootstrap.min.js"></script>
    <script src="{{ asset('/') }}js/app.js"></script>
</body>

</html>