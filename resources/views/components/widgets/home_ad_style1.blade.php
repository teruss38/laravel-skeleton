<div class="container px-0 py-2 d-none d-lg-block">
    <div class="main_ad_style1">
        <dl>
            @foreach ($carousels as $carousel)
                @if ($loop->first)
                    <dt>
                        <a href="{{ $carousel->url }}" target="_blank" rel="nofollow">
                            <img class="d-block w-100" src="{{ $carousel->image }}" alt="{{ $carousel->name }}">
                        </a>
                    </dt>
                @else
                    <dd>
                        <a href="{{ $carousel->url }}" target="_blank" rel="nofollow">
                            <img class="d-block w-100" src="{{ $carousel->image }}" alt="{{ $carousel->name }}">
                        </a>
                    </dd>
                @endif
            @endforeach
        </dl>
    </div>
</div>
