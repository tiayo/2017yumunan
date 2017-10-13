@extends('home.layouts.app')

@section('title', '登录')

@section('style')
    <style type="text/css">
        .login {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .login #logo img {
            width: 50%;
            margin: 5% 25% 0 25%;
        }
        .login .title {
            width: 100%;
            height: 95px;
            color: #000;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 95px;
        }
        .login #login-dialog {
            width: 74%;
            margin: 0 auto 20px;
            background-color: #fff;
        }
        .login #user {
            height: 46px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .login #password {
            height: 46px;
            border: 1px solid #ddd;
        }
        .login #user input,
        .login #password input {
            float: right;
            width: 95%;
            height: 26px;
            margin-top: 10px;
            line-height: 25px;
            outline: none;
            border: 0;
        }
        .login #user input::-webkit-input-placeholder,
        .login #password input::-webkit-input-placeholder {
            color: #999;
        }
        .login #login-button {
            float: left;
            width: 74%;
            height: 45px;
            margin: 0 13% 10px;
            background-color: #ffda44;
            color: #fff;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 45px;
            border: 0;
        }
        .login #registration-button {
            float: left;
            width: 74%;
            height: 45px;
            margin: 0 13% 10px;
            background-color: #fff;
            box-shadow: 1px 1px #ffda44 inset,
            -1px -1px #ffda44 inset;
            color: #ffda44;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 45px;
            border: 0;
        }
        .login .error {
            height: 30px;
            color: #f00;
            line-height: 30px;
        }
    </style>
@endsection

@section('body')
<div class="login">
    <div class="title">
        欢迎登录
    </div>
    <form action="{{ route('home.login') }}" method="post">
        {{ csrf_field() }}
        <div id="login-dialog">
            <div id="user">
                <input type="text" name="username" placeholder="请输入身份证、手机其中之一"/>
            </div>
            <div id="password">
                <input type="password" name="password" placeholder="请输入密码"/>
            </div>

            @foreach($errors as $error)
                <div class="error">{{ $error }}</div>
            @endforeach
        </div>
        <button type="submit" id="login-button">登录</button>
    </form>
    <button id="registration-button" onclick="location='{{ route('home.register') }}'">注册</button>
</div>
@endsection