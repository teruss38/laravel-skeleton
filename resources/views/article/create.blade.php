@extends('layouts.app')

@section('title', __('Create Articles'))

@push('footer')
    <link href="{{ asset('vendor/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-zh-CN.min.js') }}"></script>
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/i18n/zh-CN.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#content').summernote({
                lang: 'zh-CN',
                height: 350,
                placeholder: '撰写文章',
            });
            $('#tag_values').select2({
                placeholder: "选择话题",
                minimumInputLength: 1,
                maximumSelectionLength: 5,
                multiple: true,
                tags: true,
                allowClear: true,
                ajax: {
                    url: '{{route('tag.auto-complete')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                            query: params.term,
                            limit: 15
                        }
                        return query;
                    },
                    processResults: function (data) {
                        var data = $.map(data, function (obj) {
                            obj.id = obj.name;
                            obj.text = obj.name;
                            return obj;
                        });
                        return {
                            results: data
                        };
                    },
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumb">
            您现在的位置：
            <a class="breadcrumb-item" href="{{ url('/')}}">{{ __('Home') }}</a>
            <a class="breadcrumb-item" href="{{ route('article.index') }}">{{ __('Articles') }}</a>
            <span class="breadcrumb-item active">{{ __('Create Articles') }}</span>
        </nav>
        <div class="row">
            <div class="col-md-12 main widget-form">
                <form id="article_form" method="POST" role="form" enctype="multipart/form-data"
                      action="{{ route('article.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">文章标题</label>
                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}"
                               aria-describedby="title" placeholder="我想起那天下午在夕阳下的奔跑,那是我逝去的青春">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="thumbnail">文章封面</label>
                        <input type="file" class="form-control-file @error('thumb') is-invalid @enderror" name="thumb" id="thumb">
                        <small id="thumbHelp" class="form-text text-muted">建议尺寸200*120</small>
                        @error('thumb')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="0">请选择分类</option>
                                {!! \App\Models\Category::makeOptionTree(old('category_id')) !!}
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-8">
                            <select id="tag_values" name="tag_values[]" class="form-control @error('tag_values') is-invalid @enderror" multiple="multiple"></select>
                            @error('tag_values')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">文章导读</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="2"
                                  placeholder="文章摘要">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">文章正文</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="3"
                                  placeholder="文章正文">{{ old('content') }}</textarea>
                        @error('content')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>



                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">发布文章</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

