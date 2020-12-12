<ul class="list-unstyled">
    @foreach ($items as $item)
        <li class="media p-4 bg-white" style="overflow: hidden;">
            <img class="mr-4 article-img rounded" src="{{$item->thumb}}" alt="Generic placeholder image">
            <div class="media-body position-relative">
                <a href="{{ route('articles.show',$item) }}" target="_blank" class="article_url"
                   title="{{$item->title}}">
                    <h4 class="article_title">{{$item->title}}</h4>
                    <div class="article-excerpt">{{$item->description}}</div>
                </a>
                <div class="row article_userinfo small mx-0">
                    <div class="col-4 text-truncate px-0">
                        <span class="text-black-50 small">作者 :</span>
                        <a href="#" class="article_author small mr-2">{{$item->user->username}}</a>
                    </div>
                    <div class="col-8 text-right text-truncate px-0" style="color: #888;">
                        已有 <span class="read_number_style">{{$item->views}}</span>
                        人阅读・<span>{{$item->created_at}}</span>
                    </div>
                </div>
            </div>
        </li>
        @if($loop->iteration % 5 == 0)
            <li class="p-4 bg-white">广告位</li>
        @endif
    @endforeach
</ul>