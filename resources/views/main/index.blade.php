@extends('layouts.app')

@push('head')
    <meta property="og:title" content="{{ settings('system.title') }}" />
    <meta property="og:description" content="{{settings('system.description')}}" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:image" content="{{ asset('img/logo.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ config('app.name', 'Larva') }}" />
@endpush

@section('jumbotron')
    <div id="carousels" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousels" data-slide-to="0" class="active"></li>
            <li data-target="#carousels" data-slide-to="1"></li>
            <li data-target="#carousels" data-slide-to="2"></li>
            <li data-target="#carousels" data-slide-to="3"></li>
            <li data-target="#carousels" data-slide-to="4"></li>
            <li data-target="#carousels" data-slide-to="5"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{asset('img/banner/ban_01.jpg')}}" alt="拉瓦科技">
                <div class="carousel-caption d-none d-md-block ">
                    <h1>拉瓦科技</h1>
                    <p>这次是为了玩真的，安全、性能、大数据统统都有!</p>
                    <a href="https://www.larva.com.cn" target="_blank" class="btn-ban">了解详情&nbsp;&gt;&gt;</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('img/banner/ban_02.jpg')}}" alt="CodeForces">
                <div class="carousel-caption d-none d-md-block text-left">
                    <h1>CodeForces</h1>
                    <h6>非常全面、好用的源代码分享、下载网站。</h6>
                    <p>我们致力于为广大 IT 开发者、程序员、编程爱好者、互联网领域工作者提供海量的程序！</p>
                    <a href="https://www.codeforces.cn" target="_blank" class="btn-ban">了解详情&nbsp;&gt;&gt;</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('img/banner/ban_03.jpg')}}" alt="网址目录">
                <div class="carousel-caption d-none d-md-block text-left">
                    <h1>网址目录</h1>
                    <h6>网址目录汇集全国所有高质量网站，</h6>
                    <p>给站长提供免费网址目录提交收录和推荐最新最全的优秀网站大全是名站导航之家！</p>
                    <a href="https://www.wzdir.cn" target="_blank" class="btn-ban">了解详情&nbsp;&gt;&gt;</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('img/banner/ban_04.jpg')}}" alt="全球网址目录">
                <div class="carousel-caption d-none d-md-block text-left">
                    <h1>全球网址目录</h1>
                    <h6>网址目录汇集全球所有高质量网站，</h6>
                    <p>给站长提供免费网址目录提交收录和推荐最新最全的优秀网站大全是名站导航之家！</p>
                    <a href="https://www.wzdir.net" target="_blank" class="btn-ban">了解详情&nbsp;&gt;&gt;</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('img/banner/ban_05.jpg')}}" alt="AIForge">
                <div class="carousel-caption d-none d-md-block text-left">
                    <h1>AiForge</h1>
                    <p>无论 AI，服务器，芯片，嵌入式，IoT 相关开发，全球软硬件资源信息！</p>
                    <a href="https://www.aiforge.cn" target="_blank" class="btn-ban">了解详情&nbsp;&gt;&gt;</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('img/banner/ban_06.jpg')}}" alt="小程序目录">
                <div class="carousel-caption d-none d-md-block text-left">
                    <h1>小程序目录</h1>
                    <p>小程序目录网收录优质的微信小程序和微信小游戏，致力于成为一个小程序分发优质网站。</p>
                    <a href="https://www.laua.cn" target="_blank" class="btn-ban">了解详情&nbsp;&gt;&gt;</a>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousels" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">上一幅</span>
        </a>
        <a class="carousel-control-next" href="#carousels" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">下一幅</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="container">
        这是首页
        <div class="row">
            <div class="col-md-12">
                <div class="side_box mb-3">
                    <div class="box-header">
                        <div class="box-title">友情链接</div>
                    </div>
                    <div class="box-body">
                        <x-widgets.link type="home"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
