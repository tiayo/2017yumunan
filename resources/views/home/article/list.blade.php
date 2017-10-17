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
    <div id="news">
        <ul class="news">
            @foreach($lists as $list)
                <li>
                    <h1>{{ $list['title'] }}</h1>
                    <h2>{{ $list['created_at'] }}</h2>
                    <h3>{{ mb_substr(strip_tags($list['content']), 0, 100, 'utf-8') }}</h3>
                    <a href="{{ route('home.article', ['article_id' => $list['id']]) }}">阅读全文</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection