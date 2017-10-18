@extends('home.layouts.app')

@section('title', '首页')

@section('body')
    <div class="index clearfix">
        <div class="swiper-container index-bigpic clearfix">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="#"><img src="{{ asset('/style/home/picture/bigpic1.jpg') }}"/></a>
                </div>
                <div class="swiper-slide">
                    <a href="#"><img src="{{ asset('/style/home/picture/bigpic2.jpg') }}"/></a>
                </div>
                <div class="swiper-slide">
                    <a href="#"><img src="{{ asset('/style/home/picture/bigpic3.jpg') }}"/></a>
                </div>
            </div>
            <!-- 分页器 -->
            <div class="swiper-pagination"></div>
        </div>
        <div class="news clearfix">
            <strong></strong>
            <div class="swiper-containerNews clearfix">
                <div class="swiper-wrapper news-list">
                    @foreach($articles as $article)
                        <div class="swiper-slide">
                            <a href="{{ route('home.article', ['article_id' => $article['id']]) }}">{{ $article['title'] }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('home.article_list') }}">更多</a>
        </div>
        <div class="goods">
            <b class="hot-exchange clearfix">
                热销房型
                <a href="classification-list.html">更多</a>
            </b>
            <ul class="goods-con clearfix">
                @foreach($recommend_today as $commodity)
                    <li>
                        <a href="{{ route('home.commodity_view', ['comodity_id' => $commodity['id']]) }}">
                            <div id="picture">
                                <div id="content">
                                    @for($i=0; $i<9; $i++)
                                        @if (!empty($commodity['image_'.$i]))
                                            <img src="{{ $commodity['image_'.$i] }}"/>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <h2>{{ $commodity['name'] }}</h2>
                            <strong class="price clearfix">
                                <h4>{{ $commodity['price'] }}</h4>
                            </strong>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="copyright">
            <h1>© {{ config('site.title') }} 版权所有</h1>
        </div>
    </div>
    <div class="nav clearfix">
        <a href="{{ route('home.person') }}"></a >
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
        var mySwiperNews = new Swiper ('.swiper-containerNews', {
            direction: 'vertical',
            loop: true,
            autoplay: 3000,
            autoplayDisableOnInteraction : false,
        });
    </script>
@endsection