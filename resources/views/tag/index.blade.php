@extends('layouts.app')

@section('title', __('Topics'))

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tag.index') }}">{{ __('Topics') }}</a></li>
        </ol>

        <div class="row">
            <div class="col shadow">
                <div class="page-title"><h1 class="h2">标签聚合</h1></div>
                <div class="page-body">
                    <ul class="tag-list">
                        @foreach($tags as $tag)
                            <li><a target="_blank" href="{{route('tag.show',['id'=>$tag->id])}}">{{$tag->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>


@endsection
