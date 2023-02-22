@extends('admin.layout.index')
@section('content')
    <main id="content" role="main" class="main">
        <div class="content container-fluid">

            {{-- Page Header --}}
            @include('admin.layout.add.headerPage', [
                         'breadcrumb_list' => 'news/list',
                         'breadcrumb' => 'News Tutorials',
                         'page' => 'Edit',
                         'pagetitle' => "Chỉnh sửa tin tức: $news->title",
                         'linklist' => 'news/list',
                         'list' => 'List News Tutorials'
                 ])
            {{-- End Page Header --}}

            @include('admin.layout.alert')

            <form id="news" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-3 mb-lg-5">
                            {{-- Header --}}
                            @include('admin.layout.edit.headerForm', ['headertitle' => "News Tutorial $news->title Information"])
                            {{-- End Header --}}

                            <div class="card-body">
                                {{-- Form Group Title --}}
                                <div class="form-group required">
                                    <label for="title" class="input-label">Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                           value="{{ $news->title }}" placeholder="Tiêu đề tin tức" required>
                                </div>
                                {{-- End Form Group Title --}}

                                <div class="row">
                                    {{-- Form Group Category --}}
                                    <div class="col-sm-3">
                                        <div class="form-group required">
                                            <label for="cate" class="input-label">Category</label>
                                            <select class="js-select2-custom custom-select" id="cate" name="cate"
                                                    size="1" style="opacity: 0;" data-hs-select2-options='{
                                                    "minimumResultsForSearch": "Infinity", "placeholder": "Chọn thể loại ứng dụng"}'>
                                                <option value=""></option>
                                                @foreach($category as $cate)
                                                    <option value="{{ $cate->app_id }}">{{ $cate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- End Form Group Category --}}

                                    {{-- Form Group Application --}}
                                    <div class="col-sm-4">
                                        <div class="form-group required">
                                            <label for="app_id" class="input-label">Application</label>
                                            <select class="js-select2-custom custom-select" id="app_id" name="app_id"
                                                    size="1" style="opacity: 0;" required
                                                    data-hs-select2-options='{"minimumResultsForSearch": "Infinity",
                                                    "placeholder": "Chọn Category để hiện Application"}'>
                                                <option value="0" disabled>Chọn Category để hiện Application</option>
                                                <option value="{{ $news->app_id }}"
                                                        selected>{{ $news->newsApp->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- End Form Group Application --}}

                                    {{-- Form Group Status and Top --}}
                                    <div class="col-sm-5">
                                        @include('admin.layout.edit.top', ['model' => 'News', 'value' => 'news'])
                                    </div>
                                    {{-- End Form Group Status and Top Application --}}
                                </div>

                                {{-- Form Group Content --}}
                                <div class="form-group required">
                                    <label class="input-label required">Nội dung</label>
                                    <textarea name="content" id="content" class="form-control tinymce"
                                              rows="10" required>{{ $news->content }}</textarea>
                                </div>
                                {{-- End Form Group Content --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header">
                                <h4 class="card-header-title">Image Tutorial</h4>
                            </div>
                            <!-- End Header -->

                            <div class="card-body">
                                {{-- Image News --}}
                                @include('admin.layout.edit.image', [
                                        'name_img' => 'image',
                                        'class' => 'image',
                                        'label' => 'Ảnh minh hoạ ',
                                        'tooltip' => 'Ảnh có kích thước 480x320',
                                        'value' => 'news'
                                    ])
                                {{-- End Logo Image News --}}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <a class="btn btn-outline-primary mr-2" href="news/list">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update News Tutorial</button>
                </div>
                {{-- End Footer --}}
            </form>
        </div>
    </main>
@endsection

@section('js')
    <script src="{{asset('/assets/js/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('/assets/js/custom/news/tutorial/news.js')}}"></script>
@endsection
