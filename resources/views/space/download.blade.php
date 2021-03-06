@extends('space.layout')

@section('title') @if(Auth()->check() && Auth()->user()->id === $user->id )我的资源 @else 他的资源 @endif  @endsection

@section('main')
    <div class="space-main">
        <nav class="home_tab bg-white">
            <div class="nav nav-tabs">
                <span class="nav-item nav-link active">{{$items->total()}} 个资源</span>
            </div>
        </nav>
        <ul class="stream-list">
            @foreach ($items as $item)
                <li>
                    <div class="row">
                        <div class="col-md-8 title-warp">
                            <a class="item-title" href="{{$item->link}}">{{$item->title}}</a>
                        </div>
                        <div class="col-md-2"><span class="text-muted">{{$item->views}}</span></div>
                        <div class="col-md-2">
                            <span class="text-muted">{{$item->created_at->diffForHumans()}}</span>
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
