@extends('space.layout')
@section('title') @if(Auth()->check() && Auth()->user()->id === $user->id )我的关注 @else 他的关注 @endif  @endsection
@section('main')
    <div class="space-main">
        <nav class="home_tab bg-white">
            <div class="nav nav-tabs">
                <a class="nav-item nav-link active"href="#">用户</a>
            </div>
            <div class="tab-content bg-white stream-following">
                <ul class="list-unstyled stream-following-list">
                    @foreach ($items as $item)
                        <li>
                            <div class="row">
                                <div class="col-md-10">
                                    <img class="avatar-3" src="{{$item->source->avatar}}">
                                    <div>
                                        <a href="{{route('space.index',[$item->source])}}">{{$item->source->username}}</a>
                                        <div class="stream-following-followed">{{$item->source->extra->followers}}关注</div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-right">
                                    <follow id="{{$item->source->id}}" type="user" size="sm" disabled="{{$item->source->isFollowed}}"></follow>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="text-center p-2">
                    {{ $items->links() }}
                </div>
            </div>
        </nav>
    </div>
@endsection
