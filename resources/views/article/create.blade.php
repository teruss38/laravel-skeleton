@extends('layouts.app')

@section('title', __('Create Articles'))

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('article.index') }}">{{ __('Articles') }}</a></li>
            <span class="breadcrumb-item active">{{ __('Create Articles') }}</span>
        </ol>

        <div class="row">
            <div class="col-md-12 widget-form">
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
                        <input type="file" class="form-control-file @error('thumb_path') is-invalid @enderror" name="thumb_path" id="thumb_path">
                        <small id="thumbHelp" class="form-text text-muted">建议尺寸200*120</small>
                        @error('thumb_path')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="0">请选择分类</option>
                                {!! \App\Models\ArticleCategory::makeOptionTree(old('category_id')) !!}
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

