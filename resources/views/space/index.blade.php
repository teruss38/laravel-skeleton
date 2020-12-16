@extends('space.layout')

@section('main')
    <div class="space-main">
        <nav class="home_tab bg-white">
            <div class="nav nav-tabs">
                <span class="nav-item nav-link active">推荐</span>
            </div>
        </nav>
        <ul class="stream-list">
            @foreach ($items as $item)
                <li>
                    <div class="row">
                        <div class="col-md-8 title-warp">
                            <a class="item-title" href="{{$item->source->link}}">{{$item->source->title}}</a>
                        </div>
                        <div class="col-md-2"><span class="text-muted">{{$item->source->views}}查看</span></div>
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
