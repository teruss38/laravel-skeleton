@extends('space.layout')

@section('title') @if(Auth()->check() && Auth()->user()->id === $user->id )我的收藏 @else 他的收藏 @endif  @endsection

@section('main')
    <div class="space-main">
        <h6 class="heading">{{$items->total()}} 个收藏</h6>
        <ul class="stream-list">
            <li>
                <div class="row">
                    <div class="col-md-8 title-warp">
                        <strong>标题</strong>
                    </div>
                    <div class="col-md-2">
                        <strong>浏览/收藏</strong>
                    </div>
                    <div class="col-md-2">
                        <strong>收藏日期</strong>
                    </div>
                </div>
            </li>
            @foreach ($items as $item)
                <li>
                    <div class="row">
                        <div class="col-md-8 title-warp">
                            <a class="item-title" href="{{$item->source->link}}">{{$item->source->title}}</a>
                        </div>
                        <div class="col-md-2"><span class="text-muted">{{$item->source->views}} / {{$item->source->collection_count}}</span></div>
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
