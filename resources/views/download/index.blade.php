@extends('layouts.app')

@if (isset($category))
    @section('title', $category->title.'_'. __('Downloads'))
    @section('keywords', $category->keywords)
    @section('description', $category->description)
@else
    @section('title', __('Downloads'))
    @section('keywords', '程序源代码,开源程序,开发,分享,搜索,下载,code,Android,iOS,Matlab,c++, python, java, perl,c#,javascript,PHP,c语言,编程,程序员')
    @section('description', '非常全面、好用的源代码分享、下载网站。我们致力于为广大 IT 开发者、程序员、编程爱好者、互联网领域工作者提供海量的程序源代码、开源程序、开源工程，开发、分享、搜索和下载服务。')
@endif

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="d-none d-lg-block pr-lg-0 col-lg-1">
                @if (isset($category))
                    <x-widgets.side-download-category id="{{$category->id}}"/>
                @else
                    <x-widgets.side-download-category/>
                @endif
            </div>
            <div class="d-block pr-0 col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="side_box">
                    <div class="box-header">
                        <div class="box-title">@if (isset($category)) {{$category->title}} @else {{__('Downloads')}} @endif</div>
                    </div>
                    <div class="download-list">
                    @foreach ($items as $item)
                        <div class="download-card">
                            <div class="download-img"><img src="{{ $item->fileIcon }}"></div>
                            <h2 class="download-title">
                                <a href="{{ $item->link }}">{{$item->title}}</a>
                                <span class="download-meta">下载:{{$item->download_count}} · <time
                                        datetime="{{$item->created_at}}">{{$item->created_at->diffForHumans()}}</time></span>
                            </h2>

                            <div class="download-desc">
                                <a href="{{ $item->link }}">
                                    {{$item->description}}
                                </a>
                            </div>
                        </div>
                    @endforeach

                    {{ $items->links() }}
                </div>
                </div>
            </div>

            <div class="d-none d-lg-block col-lg-3">
                @include('layouts._side')
            </div>
        </div>
        <x-widgets.inner-link/>
    </div>
@endsection
