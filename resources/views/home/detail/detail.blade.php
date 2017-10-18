@extends('home.layouts.app')

@section('title', '商品详情')

@section('style')
    <style type="text/css">
        #back {
            position: fixed;
            top: 10px;
            left: 10px;
            width: 25px;
            height: 25px;
            background: url(/style/home/icon/icon_arrow_left.png) no-repeat center;
            background-size: 15px;
            box-shadow: 1px 1px 5px #000;
            border-radius: 50%;
            z-index: 999;
        }
        .room-details .room-bigpic {
            position: relative;
            width: 100%;
        }
        .room-details .room-bigpic img {
            float: left;
            width: 100%;
        }
        .room-details .room-bigpic b {
            position: absolute;
            bottom: 10px;
            left: 10px;
            height: 30px;
            color: #fff;
            font-size: 16px;
            line-height: 30px;
            z-index: 999;
        }
        .room-details .room-info {
            padding: 10px 10px 55px;
        }
        .room-details .room-name {
            height: 45px;
            line-height: 45px;
        }
        .room-details .room-name span {
            float: left;
            height: 100%;
            color: #000;
            font-size: 18px;
            font-weight: bold;
        }
        .room-details .room-name strong {
            float: right;
            height: 100%;
            color: #999;
        }
        .room-details .confirm {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 45px;
            outline: none;
            border: 0;
            color: #fff;
            background-color: #69eaff;
            font-size: 16px;
            font-weight: bold;
            text-indent: 5px;
            letter-spacing: 5px;
            text-align: center;
            line-height: 45px;
        }
    </style>
@endsection

@section('body')
    <div class="room-details">
        <a href="/" id="back"></a>
        <div class="swiper-container room-bigpic clearfix">
            <div class="swiper-wrapper">
                @for($i=0; $i<9; $i++)
                    @if (!empty($commodity['image_'.$i]))
                        <div class="swiper-slide">
                            <a href="#"><img src="{{ $commodity['image_'.$i] }}"/></a>
                        </div>
                    @endif
                @endfor
            </div>
            <!-- 分页器 -->
            <div class="swiper-pagination"></div>
            <b>{{ $commodity['name'] }}</b>
        </div>
        <div class="room-info">
            <div class="room-name"><span>房型信息</span><strong>剩余 <em>{{ $commodity->room->where('status', 1)->count() }}</em> 间</strong></div>
            <div class="info-con">
                {!! $commodity['description'] !!}
            </div>
        </div>
        <button class="confirm" onclick="location='{{ route('home.order_add', ['commodity_id' => $commodity['id']])  }}'">立即预定</button>
    </div>
    <script type="text/javascript">
        var mySwiper = new Swiper ('.swiper-container', {
            direction: 'horizontal',
            loop: true,
            autoplay: 3000,
            autoplayDisableOnInteraction : false,
            // 分页器
            pagination: '.swiper-pagination',
        });
    </script>
@endsection