<ul class="list-group">
    @foreach($categories as $category)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{$category->link}}">{{$category->name}}</a>
    </li>
    @endforeach
</ul>
