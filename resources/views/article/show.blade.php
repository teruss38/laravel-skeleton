@extends('layouts.app')



@section('content')

    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumb">
            您现在的位置：
            <a class="breadcrumb-item" href="{{ url('/')}}">{{ __('Home') }}</a>
            <a class="breadcrumb-item" href="{{ route('article.index') }}">{{ __('Articles') }}</a>
            <span class="breadcrumb-item active">{{$article->title}}</span>
        </nav>
        <div class="row">
            <div class="col col-lg-9">
                <div class="article-detail shadow">
                    <h1>{{$article->title}}</h1>
                    <div class="article-time d-flex justify-content-start">
                        <span>{{$article->created_at}}</span>
                        <span class="ml-1">来源：{{$article->from}}</span>
                        <span class="ml-1">{{__('Views')}}：{{$article->views}}</span>
                    </div>
                    <article>
                        {!! $article->content !!}

                        标签：
                        @foreach($article->tags as $tag)
                            <a href="{{ route('tag.articles',['id'=>$tag->id]) }}" class="tag"
                               title="{{$tag->name}}">{{$tag->name}}</a>
                        @endforeach
                    </article>

                    <div class="mt-3 article-bottom">
                        @if($article->previous)
                            <span class="float-left">
                            上一篇：<a href="{{ route('article.show',['id'=>$article->previous->id]) }}"
                                   title="{{$article->previous->title}}">{{$article->previous->title}}</a>
                        </span>
                        @endif
                        @if($article->next)
                            <span class="float-right">
                            下一篇：<a href="{{ route('article.show',['id'=>$article->next->id]) }}"
                                   title="{{$article->next->title}}">{{$article->next->title}}</a>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="card mt-3 shadow">
                    <div class="card-header">
                        相关阅读
                    </div>
                    <div class="card-body related-article">
                        <div class="article-title">
                            <a href="/news/c463e7215b01a91f6e18c90643eebdc8" class="ignored" title="盖茨重夺全球首富 因亚马逊股价大跌">盖茨重夺全球首富
                                因亚马逊股价大跌</a>
                            <span>2019-10-25 13:37:53</span>
                        </div>

                        <div class="article-title">
                            <a href="/news/c6500618aac549c68a3ce4dc77fdc508" class="ignored"
                               title="2019年Q3中国安卓智能手机报告：华为占比达到39.4%">2019年Q3中国安卓智能手机报告：华为占比达到39.4%</a>
                            <span>2019-10-25 11:32:21</span>
                        </div>

                        <div class="article-title">
                            <a href="/news/98c88527235b67fec83d5fca08df6c66" class="ignored"
                               title="支付宝宣布36万招找茬程序员 不限年龄、性别、学历">支付宝宣布36万招找茬程序员 不限年龄、性别、学历</a>
                            <span>2019-10-25 10:39:05</span>
                        </div>

                        <div class="article-title">
                            <a href="/news/a11d32a2d1fa8a82775a7cab14143f63" class="ignored"
                               title="拼多多市值超京东：跻身中国互联网上市公司前四">拼多多市值超京东：跻身中国互联网上市公司前四</a>
                            <span>2019-10-25 10:09:47</span>
                        </div>

                        <div class="article-title">
                            <a href="/news/910e893bdccce2afa0db3d88b5c2d1c3" class="ignored"
                               title="华为2019手机销量突破2亿台 为此推出2亿台纪念版">华为2019手机销量突破2亿台 为此推出2亿台纪念版</a>
                            <span>2019-10-24 11:08:10</span>
                        </div>

                        <div class="article-title">
                            <a href="/news/fad85b843188689b93ae1f32aa1f3494" class="ignored" title="微信支付新增功能：可直接向手机号转账">微信支付新增功能：可直接向手机号转账</a>
                            <span>2019-10-24 10:51:04</span>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col col-lg-3">
                <div class="card">
                    <a target="_blank" href="/order/vip">
                        <img class="card-img-top" src="https://www.weimao.com/built/images/vip.jpg"
                             alt="Card image cap">
                    </a>
                </div>

                <div class="card mt-3 shadow">
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
