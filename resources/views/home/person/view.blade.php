@inject('index', 'App\Services\Home\IndexService')
@extends('home.layouts.app')

@section('title', '个人中心')

@section('body')
    <div class="pc">
        <div class="info">
            <img src="{{ Auth::user()['avatar'] }}" class="portrait" />
            <span class="name">{{ Auth::user()['name'] }}</span>
            <a href="{{ route('home.person_update') }}" class="more"></a>
        </div>
        <div class="title">我的订单</div>
        <ul class="order-nav">
            <li class="on">全部</li>
            <li>入住</li>
            <li>已完成</li>
        </ul>
        <div class="content" id="content">
            <div class="con" style="display:block" >
                <ul class="all-list">
                    @foreach($orders_all as $order)
                        <li class="clearfix">
                            <a href="#" class="info">
                                <h4><strong class="status">{{ config('site.order_status')[$order['status']] }}</strong></h4>
                                <ul class="clearfix">
                                    <li><em>电话：</em><span>{{ Auth::user()['phone'] }}</span></li>
                                    <li><em>房间数：</em><span>{{ $order['num'] }}</span></li>
                                    <li><em>入住天数：</em><span>{{ $order['day'] }}</span></li>
                                </ul>
                                <em class="combined"><span>{{ $order['day'] * $order['num'] * $order['price'] }}</span></em>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="con">
                <ul class="send-list">
                    @foreach($orders_1 as $order)
                        <li class="clearfix">
                            <a href="#" class="info">
                                <h4><strong class="status">{{ config('site.order_status')[$order['status']] }}</strong></h4>
                                <ul class="clearfix">
                                    <li><em>电话：</em><span>{{ Auth::user()['phone'] }}</span></li>
                                    <li><em>房间数：</em><span>{{ $order['num'] }}</span></li>
                                    <li><em>入住天数：</em><span>{{ $order['day'] }}</span></li>
                                </ul>
                                <em class="combined"><span>{{ $order['day'] * $order['num'] * $order['price'] }}</span></em>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="con">
                <ul class="accept">
                    @foreach($orders_2 as $order)
                        <li class="clearfix">
                            <a href="#" class="info">
                                <h4><strong class="status">{{ config('site.order_status')[$order['status']] }}</strong></h4>
                                <ul class="clearfix">
                                    <li><em>电话：</em><span>{{ Auth::user()['phone'] }}</span></li>
                                    <li><em>房间数：</em><span>{{ $order['num'] }}</span></li>
                                    <li><em>入住天数：</em><span>{{ $order['day'] }}</span></li>
                                </ul>
                                <em class="combined"><span>{{ $order['day'] * $order['num'] * $order['price'] }}</span></em>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="nav clearfix">
        <a href="index.html"></a>
    </div>
    <script type="text/javascript">
        $(".order-nav li").click(function() {
            $(this).addClass('on').siblings().removeClass('on');
            $(".pc .content .con").hide().eq($(".order-nav li").index(this)).show();
        });
    </script>
@endsection