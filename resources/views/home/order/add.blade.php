@inject('index', 'App\Services\Home\IndexService')
@extends('home.layouts.app')

@section('title', '结算页面')

@section('body')
    <form action="{{ route('order_add') }}" method="post">
        {{ csrf_field() }}
        <input name="commodity_id" type="hidden" value="{{ $commodity['id'] }}">
        <input name="status" type="hidden" value="0">
        <div class="goods-settlement clearfix" id="vue">
            <div class="content">
                <div class="info">
                    <h1 class="name">天元酒店</h1>
                    <ul>
                        <li>房型：<span>{{ $commodity['name'] }}</span></li>
                        <li>单价：<span>￥<em class="dj">{{ $commodity['price'] }}</em>/天/间</span></li>
                        <li>入住时间：<span class="now">{{ date('Y-m-d') }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="address">
                <h1>入住信息</h1>
                <div>
                    <label for="">姓名：</label>
                    <input class="name-input" name="name" type="text" value="{{ $user['name'] }}"
                           placeholder="点击填写入住人姓名"/>
                </div>
                <div>
                    <label for="">电话：</label>
                    <input class="tel-input" name="phone" type="text" value="{{ $user['phone'] }}"
                           placeholder="点击填写联系电话"/>
                </div>
                <div>
                    <label for="">入住天数：</label>
                    <input class="address-input" id="day_num" name="day" type="number" placeholder="点击输入天数" value="1"/>
                </div>
                <div>
                    <label for="">房间数：</label>
                    <input class="address-input" id="num_num" name="num" type="number" placeholder="点击输入房间数" value="1"/>
                </div>
                <div>
                    <label for="">身份证：</label>
                    <input class="tel-input" name="id_number" type="text"  value="{{ $user['id_number'] }}"
                           placeholder="点击填写联系电话"/>
                </div>
                <div>
                    <label for="">备注：</label>
                    <input class="tel-input" name="remark" type="text"  value="点击填写备注"/>
                </div>
            </div>
            <div class="nav-bottom">
                <h1>合计:<span></span></h1>
                <button type="submit" href="payfor-success.html">提交订单</button>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        var mydate = new Date();
        var time = "" + mydate.getFullYear() + "年";
        time += (mydate.getMonth()+1) + "月";
        time += mydate.getDate() + "日";
        $(".now").html(time);
        $(".nav-bottom h1 span").html($(".dj").text());
        $(".address-input").blur(function() {
            $(".nav-bottom h1 span").html($(".dj").text() * parseInt($('#day_num').val() * $('#num_num').val()));
        });
    </script>
    </body>
@endsection