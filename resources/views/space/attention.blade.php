@extends('space.layout')

@section('main')
    <div class="space-main">
        <h6 class="heading">{{$items->total()}} 条记录</h6>

        <div class="stream-following border-top">
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
    </div>
@endsection
