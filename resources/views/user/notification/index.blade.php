@extends('layouts.app')

@section('title', __('My Notifications'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-9">
                <h4 class="mt-3 mb-3">
                    通知<span class="float-right"><notification-mark-as-read></notification-mark-as-read></span>
                </h4>
                <div class="widget-notify border-top">
                    @foreach($notifications as $notification)
                        <section class="notify-item @if($notification->read_at==null) not_read @endif">
                            <a href="{{ route('user.space',['id'=>$notification->data['user']['id']]) }}">{{ $notification->data['user']['username'] }}</a>
                            @if(in_array($notification->type,['App\Notifications\ArticleCollectionNotification','App\Notifications\ArticleSupportNotification']))
                                {!! $notification->data['html'] !!}
                            @else
                                {{$notification->type}}
                            @endif
                            <span class="text-muted ml-2">{{ $notification->created_at}}</span>
                        </section>
                        @php $notification->markAsRead(); @endphp
                    @endforeach

                    {{ $notifications->links() }}
                </div>
            </div>

            <div class="d-none d-xl-block col-lg-3">
                @include('user._right_menu')
            </div>
        </div>
    </div>
@endsection
