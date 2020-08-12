@extends('layouts.app')

@section('title', ($article->seo['title'] ?? $article->title).'_'.$article->category->title.'_'.__('Articles'))
@section('keywords', $article->seo['keywords'] ?? $article->tag_values)
@section('description', $article->seo['description'] ?? $article->description)

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/')}}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('article.index') }}">{{ __('Articles') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ $article->category->link }}">{{ $article->category->title }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$article->title}}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col col-lg-9">
                <div class="article bg-white shadow">
                    <div class="article-heading">
                        <div class="title">{{$article->title}}</div>
                        <div class="info">
                            <span>来源：{{$article->from}}</span>
                            <span>发布时间：{{$article->created_at}}</span>
                            <span>阅读：{{$article->views}}</span>
                        </div>
                    </div>
                    <div class="article-body">
                        {!! $article->content !!}

                        标签：
                        @foreach($article->tags as $tag)
                            <a href="{{ route('tag.articles',['id'=>$tag->id]) }}" class="tag"
                               title="{{$tag->name}}">{{$tag->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col col-lg-3">
                <div class="card shadow">
                    <div class="card-header">
                        最近更新
                    </div>
                    <div class="articles-li">
                        <div class="articles-change">
                            @foreach($latestArticles as $latestArticle)
                                @if($latestArticle->id != $article->id)
                                    <div class="articles-title">
                                        <a href="{{$latestArticle->link}}" class="ignored"
                                           title="{{$latestArticle->title}}">{{$latestArticle->title}}</a>
                                        <span>{{\Carbon\Carbon::parse($latestArticle->created_at)->diffForHumans()}}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card my-3">
                    <div class="card-body">
                        广告
                    </div>
                </div>

                <div class="card my-3 shadow">
                    <div class="card-header">
                        热门推荐
                    </div>
                    <div class="articles-li">
                        <div class="articles-change">
                            @foreach($recommendedArticles as $recommendedArticle)
                                @if($recommendedArticle->id != $article->id)
                                    <div class="articles-title">
                                        <a href="{{$recommendedArticle->link}}" class="ignored"
                                           title="{{$recommendedArticle->title}}">{{$recommendedArticle->title}}</a>
                                        <span>{{\Carbon\Carbon::parse($recommendedArticle->created_at)->diffForHumans()}}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
