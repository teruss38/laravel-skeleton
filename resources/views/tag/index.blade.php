@extends('layouts.app')

@section('title', __('Topics'))

@section('content')
    <div class="container">
        <div class="mt-4 shadow">
            <div class="page-title"><h1 class="h2">标签聚合</h1></div>
            <div class="page-body">
                <ul class="tag-list">
                    @foreach($tags as $tag)
                        <li><a target="_blank" href="{{route('tag.show',['id'=>$tag->id])}}">{{$tag->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
@endsection
