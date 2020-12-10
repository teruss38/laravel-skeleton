@extends('layouts.app')

@section('title', $news->title.'_'.__('News'))
@section('keywords', $news->keywords)
@section('description', $news->description)

@push('head')
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}"/>
    <meta property="og:image" content="{{$news->thumb}}"/>
    <meta property="og:release_date" content="{{$news->created_at}}"/>
    <meta property="og:url" content="{{$news->link}}"/>
    <meta property="og:title" content="{{$news->title}}"/>
    <meta property="og:description" content="{{$news->description}}"/>

    <meta itemprop="name" content="{{$news->title}}"/>
    <meta itemprop="description" content="{{$news->description}}"/>
    <meta itemprop="image" content="{{$news->thumb}}"/>
@endpush

@section('content')
    <div class="container">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ url('/')}}"><i class="fa fa-home"></i> {{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('news.index') }}">{{ __('News') }}</a></li>
            <li class="breadcrumb-item active">正文</li>
        </ol>
        <div class="row">
            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="article news bg-white position-relative px-3">
                    <div class="article-header">
                        <div class="article-title">{{ $news->title }}</div>
                        <div class="article-meta">
                            @if($news->from)
                                <span class="item">来源： {{$news->from}}</span>
                            @endif
                            <span class="item">发布时间：{{$news->created_at}}</span>
                            <span class="item">阅读：{{$news->views}}</span>
                        </div>
                    </div>
                    <article class="article-content ck-content">
                        {!! $news->description !!}
                    </article>
                    <div class="text-center">
                        <a href="{{$news->from_url}}" class="btn btn-primary" rel="nofollow" target="_blank">{{$news->from}}AAA</a>
                    </div>
                    <div class="d-none d-md-block article-footer mt-4">
                        @if($news->tag_values)
                            <div class="keywords">
                                @foreach($news->tags as $tag)
                                    <a href="{{ route('tag.news',['id'=>$tag->id]) }}" title="{{$tag->name}}">{{$tag->name}}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-none d-xl-block col-lg-3">
                @include('layouts._side')
            </div>
        </div>
    </div>
@endsection
