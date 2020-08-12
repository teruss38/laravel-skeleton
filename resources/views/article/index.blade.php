@extends('layouts.app')

@if (isset($category))
    @section('title', $category->title.'_'. __('Articles'))
    @section('keywords', $category->title)
    @section('description', $category->description)
@else
    @section('title', __('Articles'))
    @section('keywords', __('Articles'))
    @section('description', __('Articles'))
@endif

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('article.index') }}">{{ __('Articles') }}</a></li>
            @isset($category)
                <li class="breadcrumb-item active"><a href="{{ $category->link }}">{{ $category->title }}</a></li>
            @endisset
        </ol>
        <div class="row">
            <div class="col-md-9">
                <div class="article-list bg-white shadow">
                    <div class="article-list-head">{{$category->title ?? __('Articles')}}</div>

                    <div class="article-list-contain">
                        @foreach ($items as $item)
                            <div class="item">
                                @if ($item->thumb)
                                    <div class="image">
                                        <img src="{{$item->thumb}}">
                                    </div>
                                @endif
                                <div class="content">
                                    <a class="header" href="{{ route('article.show',['id'=>$item->id]) }}"
                                       title="{{$item->title}}">{{$item->title}}</a>
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
            <div class="col-md-3">
                <div class="card shadow">
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
    </div>
@endsection
