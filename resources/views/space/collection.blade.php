@extends('space.layout')

@section('title') @if(Auth()->check() && Auth()->user()->id === $user->id )我的收藏 @else 他的收藏 @endif  @endsection

@section('main')
    <div class="space-main">
        <nav class="home_tab bg-white">
            <div class="nav nav-tabs">
                <a class="nav-item nav-link @if($type==='article') active @endif" href="{{ route('space.collections',['user'=>$user,'type'=>'article']) }}">文章</a>
                <a class="nav-item nav-link @if($type==='download') active @endif" href="{{ route('space.collections',['user'=>$user,'type'=>'download']) }}">资源</a>
            </div>
        </nav>

        <ul class="stream-list">
            @foreach ($items as $item)
                <li>
                    <div class="row">
                        <div class="col-md-8 title-warp">
                            <a class="item-title" href="{{$item->source->link}}">{{$item->source->title}}</a>
                        </div>
                        <div class="col-md-2"><span class="text-muted">{{$item->source->views}}查看 / {{$item->source->collection_count}}收藏</span></div>
                        <div class="col-md-2">
                            <span class="text-muted">{{$item->created_at}}</span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="text-center p-2">
            {{ $items->links() }}
        </div>
    </div>
@endsection
