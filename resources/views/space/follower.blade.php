@extends('space.layout')

@section('title') @if(Auth()->check() && Auth()->user()->id === $user->id )我的粉丝 @else 他的粉丝 @endif  @endsection

@section('main')
    <div class="space-main">
        <nav class="home_tab bg-white">
            <div class="nav nav-tabs">
                <span class="nav-item nav-link active">{{$items->total()}} 条记录</span>
            </div>
        </nav>
        <div class="stream-following">
            <ul class="list-unstyled stream-following-list">
                @foreach ($items as $item)
                    <li>
                        <div class="row">
                            <div class="col-md-10">
                                <img class="avatar-3" src="{{$item->user->avatar}}">
                                <div>
                                    <a href="{{route('space.index',[$item->user])}}">{{$item->user->username}}</a>
                                    <div class="stream-following-followed">{{$item->user->extra->followers}}关注</div>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <follow id="{{$item->user->id}}" type="user" size="sm" disabled="{{$item->user->isFollowed}}"></follow>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="text-center p-2">
                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection
