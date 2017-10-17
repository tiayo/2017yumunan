@extends('home.layouts.app')

@section('title', '资讯列表')

@section('style')
    <style>
        .show-details img {
            width: 92%;
        }
    </style>
@endsection

@section('body')
    <div class="news-details">
        <h1>{{ $article['title'] }}</h1>
        <h2>{{ $article['created_at'] }}</h2>
        <div>{!! $article['content'] !!}</div>
    </div>
@endsection