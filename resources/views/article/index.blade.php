@extends('layouts.app')

@section('title', $category_title)
@section('description', $category_description)

@section('content')
    <div class="container">
        <div class="article-categories shadow">
            <ul class="category-list">
                @foreach ($categories as $category)
                <li>
                    <a href="{{$category->link}}" title="{{$category->title}}" class="category @if ($category_id == $category->id) active @endif">{{$category->title}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-9">
                <div class="article-list">
                    <div class="article-list-head">{{$category_title}}</div>

                    <div class="article-list-contain">
                        @foreach ($items as $item)
                        <div class="item">
                            @if ($item->thumb)
                                <div class="image">
                                    <img src="{{$item->thumb}}">
                                </div>
                            @endif
                            <div class="content">
                                <a class="header" href="{{ route('article.show',['id'=>$item->id]) }}" title="{{$item->title}}">{{$item->title}}</a>
                                <div class="description">
                                    <p>{{$item->description}}</p>
                                </div>
                                <div class="meta">
                                    {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}
                                </div>
                            </div>
                        </div>
                        @endforeach

                        {{ $items->links() }}
                    </div>
                </div>
            </div>
            <div class="col col-lg-3">
{{--                <div class="card">--}}
{{--                    <a target="_blank" href="/order/vip">--}}
{{--                        <img class="card-img-top" src="https://www.weimao.com/built/images/vip.jpg"--}}
{{--                             alt="Card image cap">--}}
{{--                    </a>--}}
{{--                </div>--}}

                <div class="card mt-3 shadow">
                    <div class="card-header">
                        热门推荐
                    </div>
                    <div class="articles-li">
                        <div class="articles-change">
                            @foreach($recommendedArticles as $recommendedArticle)
                                <div class="articles-title">
                                    <a href="{{$recommendedArticle->link}}" class="ignored"
                                       title="{{$recommendedArticle->title}}">{{$recommendedArticle->title}}</a>
                                    <span>{{\Carbon\Carbon::parse($recommendedArticle->created_at)->diffForHumans()}}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
