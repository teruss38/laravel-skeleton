<div class="side_box mb-3">
    <div class="box-header">
        <div class="box-title">分类目录</div>
    </div>
    <ul class="list-group page-menu">
        @foreach($categories as $category)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{$category->link}}">{{$category->name}}</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{$category->link}}">{{$category->name}}</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{$category->link}}">{{$category->name}}</a>
            </li>
        @endforeach
    </ul>
</div>
