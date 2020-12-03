
    @foreach ($links as $link)
        <a href="{{$link->url}}" target="_blank" title="{{$link->title}}">{{$link->title}}</a>
    @endforeach

