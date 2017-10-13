<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <title>@yield('title')-{{config('site.title')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/style/home/css/reset.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/style/home/css/swiper-3.4.1.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/style/home/css/style.css') }}"/>
    <script src="{{ asset('/style/home/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/style/home/js/swiper-3.4.1.jquery.min.js') }}"></script>
    <script src="{{ asset('/style/home/js/script.js') }}"></script>
    @section('style')
    @show
</head>
<body>

    @section('body')
    @show

@section('script')
@show
</body>
</html>