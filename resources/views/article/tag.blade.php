@extends('layouts.app')

@section('title', __('Article'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-lg-9 main">
                @include('tag._header',['tag'=>$tag])
                <div class="article-list">
                    <div class="article-list-contain">
                        @foreach ($items as $item)
                            <div class="item">
                                @if ($item->thumbnail)
                                    <div class="image">
                                        <img src="{{$item->thumbnail}}">
                                    </div>
                                @endif
                                <div class="content">
                                    <a class="header" href="{{ route('article.show',['id'=>$item->id]) }}"
                                       title="{{$item->title}}">{{$item->title}}</a>
                                    <div class="description">
                                        <p>{{$item->description}}</p>
                                    </div>
                                    <div class="meta">
                                        {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
