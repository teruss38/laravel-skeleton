<section class="tag-header mt-2">
    <div>
        <span class="h4 tag-header-title">{{$tag->name}}</span>
    </div>
    <p class="tag-header-summary">{{$tag->description}}</p>
</section>
<ul class="nav nav-tabs">

    <li class="nav-item">
        <a class="nav-link @if (request()->route()->getName() == 'tag.articles') active @endif"
           href="{{route('tag.articles',['id'=>$tag->id])}}">{{__('Article')}}</a>
    </li>
</ul>
