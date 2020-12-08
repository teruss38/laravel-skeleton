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

    <div class="container">
        <div class="row">
            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <div class="page-header">
                    <div
                        class="page-title">@if (isset($category)) {{$category->name}} @else {{__('Articles')}} @endif</div>
                </div>
                <ul class="list-unstyled">
                    @foreach ($items as $item)
                        <li class="media p-4 bg-white" style="overflow: hidden;">
                            <img class="mr-4 article-img rounded" src="{{$item->thumb}}" alt="Generic placeholder image">
                            <div class="media-body position-relative">
                                <a href="{{ route('articles.show',$item) }}" target="_blank" class="article_url"
                                   title="{{$item->title}}">
                                    <h4 class="article_title">{{$item->title}}</h4>
                                    <div class="article-excerpt">{{$item->description}}</div>
                                </a>
                                <div class="row article_userinfo small mx-0">
                                    <div class="col-4 text-truncate px-0">
                                        <span class="text-black-50 small">作者 :</span>
                                        <a href="#" class="article_author small mr-2">{{$item->user->username}}</a>
                                        <span class="text-black-50">来源：专栏</span>
                                    </div>
                                    <div class="col-8 text-right text-truncate px-0" style="color: #888;">
                                        已有 <span class="read_number_style">{{$item->views}}</span>
                                        人阅读・<span>{{$item->created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="text-center mt-4 loadingmore_box">
                    {{ $items->links() }}
                </div>
            </div>

            <div class="d-none d-xl-block col-lg-3">
                右侧
            </div>
        </div>
    </div>
@endsection
