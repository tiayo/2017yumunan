<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Login</title>

    <link href="{{ asset('static/adminex/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/adminex/css/style-responsive.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{ asset('/static/adminex/js/html5shiv.js') }}"></script>
    <script src="{{ asset('/static/adminex/js/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body class="login-body">

<div class="container">

    <div class="form-signin" action="index.html">
        <div class="form-signin-heading text-center" style="color:#666;padding: 25px 15px 0">
            <h3 style="color: white">{{ config('site.title')  }}</h3>
        </div>
        <div class="login-wrap">
            <form method="post" action="{{ route('manage.login') }}">
                {{ csrf_field() }}
                <input type="text" class="form-control" placeholder="输入邮箱" autofocus name="email" value="{{ session('_old_input')['email'] }}" required>
                <input type="password" class="form-control" placeholder="密码" name="password" required>
                <!--错误输出-->
                <div class="form-group">
                    <div class="alert alert-danger fade in @if(!count($errors) > 0) hidden @endif" id="alert_error">
                        <a href="#" class="close" data-dismiss="alert">×</a>
                        <span>
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </span>
                    </div>
                </div>
                <button class="btn btn-lg btn-login btn-block" type="submit">
                    <i class="fa fa-check"></i>
                </button>
            </form>
            <div class="registration">

            </div>
        </div>
    </div>

</div>



<!-- Placed js at the end of the document so the pages load faster -->

<!-- Placed js at the end of the document so the pages load faster -->
<script src="{{ asset('/static/adminex/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('/static/adminex/js/bootstrap.min.js') }}"></script>
</body>
</html>