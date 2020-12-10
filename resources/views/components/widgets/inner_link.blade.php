<div class="row">
    <div class="d-none d-md-block col-md-12">
        <div class="side_box mb-3">
            <div class="box-header">
                <div class="box-title">友情链接</div>
            </div>
            <div class="box-body">
                @foreach ($links as $link)
                    <a href="{{$link->url}}" target="_blank" title="{{$link->title}}">{{$link->title}}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
