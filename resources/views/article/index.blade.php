@extends('layouts.app')

@if (isset($category))
    @section('title', $category->title.'_'. __('Articles'))
    @section('keywords', $category->keywords)
    @section('description', $category->description)
@else
    @section('title', __('Articles'))
    @section('keywords', '科技媒体,大数据,企业级服务')
@endif

@section('content')
    <div class="container d-flex justify-content-between">
        <div class="row">
            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="page-header">
                    <div class="page-title">@if (isset($category)) {{$category->name}} @else {{__('Articles')}} @endif</div>
                </div>
                @foreach ($items as $item)
                    <div class="article-item common-item">
                        <div class="row">
                            <div class="col col-9 col-xs-9 col-sm-8 col-md-8 col-lg-6 col-xl-6 common-item-left">
                                <a href="{{ route('articles.show',$item) }}" target="_blank" rel="noopener noreferrer">
                                    <div style="overflow: hidden;">
                                        <div class="pic">
                                            <img alt="cover"
                                                 data-original="https://p5.ssl.qhimg.com/sdm/229_160_100/t016553adbc5146eaae.png"
                                                 src="https://p5.ssl.qhimg.com/sdm/229_160_100/t016553adbc5146eaae.png"
                                                 style="">
                                            <div class="pic-tag  hide-in-mobile-device">
                                                <div class="tag" style="background-color: #87d068">
                                                    <span class="ant-tag-text">CTF</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col col-15 col-xs-15 col-sm-16 col-md-16 col-lg-18 col-xl-18 common-item-right">
                                <div class="info-content">
                                    <div class="title">
                                        <a target="_blank" rel="noopener noreferrer" href="{{ route('articles.show',$item) }}"> {{$item->title}}</a>
                                    </div>
                                    @if($item->tag_values)
                                    <div class="tags hide-in-mobile-device">
                                            @foreach($item->tags as $tag)
                                            <a rel="noopener noreferrer" href="{{ route('tag.articles',['id'=>$tag->id]) }}" target="_blank">
                                                <div class="tag tag-gray">
                                                    <span>{{$tag->name}}</span>
                                                </div>
                                            </a>
                                            @endforeach
                                    </div>
                                    @endif
                                    <div class="desc hide-in-mobile-device" style="margin-right: 12px;">{{$item->description}}</div>
                                    <div class="info">
                                        <div class="article-info-left">
                                            <a target="_blank" rel="noopener noreferrer" href="/member/155670">
                                                <img alt="安全客"
                                                     src="https://p1.ssl.qhimg.com/sdm/30_30_100/t0191090d7b64c96f6e.png"
                                                     class="avatar">
                                                <span class="user-name ">零时科技</span>
                                            </a>
                                            <br class="show-in-mobile-device">
                                            <span class="date">
                                                <span style="vertical-align: middle;"><i style="margin-right: 4px;" class="fa fa-clock-o"></i>{{$item->created_at}}</span>
                                            </span>
                                        </div>
                                        <div class="article-info-right hide-in-mobile-device">
                                            <span class="pv">
                                                <span class="count">{{$item->views}}</span>次阅读
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col col-xs-0 col-sm-0 col-md-0 col-lg-3 hide-in-mobile-device">
右侧
            </div>
        </div>
    </div>
@endsection
