@extends('space.layout')

@section('main')
    <div class="user_main">
        <h4 class="space-stream-heading">{{$items->total()}} 个资源</h4>
        <ul class="space-stream-list">
            <li>
                <div class="row">
                    <div class="col-md-8 space-stream-item-title-warp">
                        <strong>标题</strong>
                    </div>
                    <div class="col-md-2">
                        <strong>推荐/浏览</strong>
                    </div>
                    <div class="col-md-2">
                        <strong>发布日期</strong>
                    </div>
                </div>
            </li>
        </ul>
        <div class="text-center">

        </div>
    </div>
@endsection
