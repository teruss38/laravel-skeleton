@extends('layouts.app')

@section('title', __('About us'))

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-md-2 d-none d-md-block">
                @include('page._left')
            </div>
            <div class="col-md-10 bg-white">
                <div class="site-content">
                    <div class="entry-header">
                        <div class="entry-title">{{__('About us')}}</div>
                    </div>

                    <div class="entry-content markdown-body">
                        关于我们
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
