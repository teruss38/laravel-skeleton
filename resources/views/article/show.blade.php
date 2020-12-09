@extends('layouts.app')

@section('title', ($article->metas['title'] ?? $article->title).'_'.$article->category->name.'_'.__('Articles'))
@section('keywords', $article->metas['keywords'] ?? $article->tag_values)
@section('description', $article->metas['description'] ?? $article->description)

@push('head')
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}"/>
    <meta property="og:image" content="{{$article->thumb}}"/>
    <meta property="og:release_date" content="{{$article->created_at}}"/>
    <meta property="og:url" content="{{$article->link}}"/>
    <meta property="og:title" content="{{$article->title}}"/>
    <meta property="og:description" content="{{$article->description}}"/>

    <meta itemprop="name" content="{{$article->title}}"/>
    <meta itemprop="description" content="{{$article->description}}"/>
    <meta itemprop="image" content="{{$article->thumb}}"/>
@endpush

@section('content')
    <div class="container">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="fa fa-home"></i> {{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">{{ __('Articles') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ $article->category->link }}">{{ $article->category->name }}</a></li>
            <li class="breadcrumb-item active">正文</li>
        </ol>
        <div class="row">
            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="article bg-white position-relative px-3">
                    <div class="article-header">
                        <div class="article-title">{{ $article->title }}</div>
                        <div class="article-meta">
                            @if($article->detail->extra['from'])
                                <span class="item">来源： <a href="{{$article->detail->extra['from_url']}}" title="{{$article->detail->extra['from']}}">{{$article->detail->extra['from']}}</a></span>
                            @endif
                            <span class="item">发布时间：{{$article->created_at}}</span>
                            <span class="item">阅读：{{$article->views}}</span>
                        </div>
                    </div>
                    <article class="article-content">
                        {!! $article->detail->content !!}
                    </article>
                    <div class="d-none d-md-block article-footer mt-4">
                        <div>文章为作者独立观点，不代表{{config('app.name')}}立场。</div>
                        <div>本文由{{$article->user->username}}发表，转载此文章须经作者同意，并请附上出处( {{config('app.name')}} )及本页链接。
                        </div>
                        <div class="mylink">原文链接 {{$article->link}}</div>
                        @if($article->tag_values)
                            <div class="keywords">
                                @foreach($article->tags as $tag)
                                    <a href="{{ route('tag.articles',['id'=>$tag->id]) }}" title="{{$tag->name}}">{{$tag->name}}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-none d-xl-block col-lg-3">
右侧
            </div>
        </div>
    </div>
@endsection
