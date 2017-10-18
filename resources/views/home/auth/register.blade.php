@extends('home.layouts.app')

@section('title', '注册')

@section('style')
    <style type="text/css">
        .registration #logo img {
            width: 50%;
            margin: 5% 25% 0 25%;
        }
        .registration .title {
            width: 100%;
            height: 95px;
            color: #000;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 95px;
        }
        .registration #registration-dialog {
            width: 74%;
            margin: 0 auto 20px;
            background-color: #fff;
        }
        .registration #user {
            height: 46px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
        .registration #password {
            height: 46px;
            border: 1px solid #ddd;
        }
        .registration #user input,
        .registration #password input {
            float: right;
            width: 95%;
            height: 26px;
            margin-top: 10px;
            line-height: 25px;
            outline: none;
            border: 0;
        }
        .registration #user input::-webkit-input-placeholder,
        .registration #password input::-webkit-input-placeholder {
            color: #999;
        }
        .registration #registration-button {
            float: left;
            width: 74%;
            height: 45px;
            margin: 0 13% 10px;
            background-color: #69eaff;
            color: #fff;
            font-size: 16px;
            letter-spacing: 10px;
            text-indent: 10px;
            text-align: center;
            line-height: 45px;
            border: 0;
        }
    </style>
@endsection

@section('body')
<div class="registration">
    <div class="title">
        用户注册
    </div>
    <form action="{{ route('home.register') }}" method="post">
        {{ csrf_field() }}
        <div id="registration-dialog">
            <div id="user">
                <input type="email" name="email" placeholder="请输入邮箱" required/>
            </div>
            <div id="user">
                <input type="password" name="password" placeholder="密码" required/>
            </div>
            <div id="user">
                <input type="password" name="password_confirmation" placeholder="确认密码" required/>
            </div>
            <div id="user">
                <input type="text" name="name" placeholder="姓名" required/>
            </div>
            <div id="user">
                <input type="text" name="phone" placeholder="电话" />
            </div>
            <div id="password">
                <input type="text" name="id_number" placeholder="身份证" />
            </div>
        </div>
        <button type="submit" id="registration-button">注册</button>
    </form>
</div>
@endsection