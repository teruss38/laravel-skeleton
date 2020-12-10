<nav class="home_tab bg-white">
    <div class="nav nav-tabs">
        <a class="nav-item nav-link @if (request()->route()->getName() == 'tag.articles') active @endif"
           id="nav-main-tab" data-toggle="tab" href="{{route('tag.articles',$tag)}}"
           role="tab" aria-controls="nav-main" aria-selected="true">{{__('Articles')}}</a>

        <a class="nav-item nav-link @if (request()->route()->getName() == 'tag.news') active @endif" id="nav-news-tab"
           data-toggle="tab" href="{{route('tag.news',$tag)}}" role="tab"
           aria-controls="nav-news" aria-selected="false">{{__('News')}}</a>

    </div>
</nav>

