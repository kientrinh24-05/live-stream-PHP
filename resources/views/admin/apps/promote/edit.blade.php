@extends('admin.layout.index')
@section('content')
    <main id="content" role="main" class="main">
        <div class="content container-fluid">

            {{-- Page Header --}}
            @include('admin.layout.add.headerPage', [
                         'breadcrumb_list' => 'app/promote/list',
                         'breadcrumb' => 'Promote Application',
                         'page' => 'Edit',
                         'pagetitle' => "Chỉnh sửa đề xuất ứng dụng: {$promote->promoteApp->name}",
                         'linklist' => 'app/promote/list',
                         'list' => 'List Promote'
                 ])
            {{-- End Page Header --}}

            @include('admin.layout.alert')

            <form id="promoteApp" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-3 mb-lg-5">
                            {{-- Header --}}
                            @include('admin.layout.add.headerForm', ['headertitle' => "Chi tiết đề xuất ứng dụng {$promote->promoteApp->name}"])
                            {{-- End Header --}}

                            <div class="card-body">
                                {{-- Form Group Title --}}
                                <div class="form-group required">
                                    <label for="title" class="input-label">Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                           value="{{ $promote->title }}" placeholder="Tiêu đề đề xuất ứng dụng" required>
                                </div>
                                {{-- End Form Group Title--}}

                                <div class="row">
                                    {{-- Form Group Category --}}
                                    <div class="col-sm-3">
                                        <div class="form-group required">
                                            <label for="cate" class="input-label">Category</label>
                                            <select class="js-select2-custom custom-select" id="cate" name="cate_id"
                                                    size="1" style="opacity: 0;" required data-hs-select2-options='{
                                                    "minimumResultsForSearch": "Infinity", "placeholder": "Chọn thể loại ứng dụng"}'>
                                                <option value=""></option>
                                                @foreach($menus as $cate)
                                                    <option value="{{ $cate->id }}" {{ $promote->cate_id == $cate->id ? 'selected': ''}}>{{ $cate->name }}</option>
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
                                                <option value="{{ $promote->app_id }}" selected>{{$promote->promoteApp->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- End Form Group Application --}}

                                    {{-- Form Group Status --}}
                                    <div class="col-sm-5">
                                        @include('admin.layout.edit.status', ['value' => 'promote'])
                                    </div>
                                    {{-- End Form Group Status --}}
                                </div>

                                <div class="row">
                                    {{-- Form Group Content --}}
                                    <div class="col-sm-6">
                                        <div class="form-group required">
                                            <label for="content" class="input-label required">Nội dung</label>
                                            <textarea name="content" id="content" class="form-control tinymce"
                                                      rows="10" required>{{ $promote->content}}</textarea>
                                        </div>
                                    </div>
                                    {{-- End Form Group Content --}}

                                    {{-- Form Group Content --}}
                                    <div class="col-sm-6">
                                        <div class="form-group required">
                                            <label for="register" class="input-label required">Hướng dẫn đăng ký</label>
                                            <textarea name="register" id="register" class="form-control tinymce"
                                                      rows="10" required>{{ $promote->register }}</textarea>
                                        </div>
                                    </div>
                                    {{-- End Form Group Content --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card mb-3 mb-lg-5">
                            <!-- Header -->
                            <div class="card-header">
                                <h4 class="card-header-title">Banner Promote Application</h4>
                            </div>
                            <!-- End Header -->

                            <div class="card-body">
                                {{-- Image banner --}}
                                @include('admin.layout.edit.image', [
                                        'name_img' => 'banner',
                                        'class' => 'banner',
                                        'label' => 'Ảnh banner đề xuất ứng dụng',
                                        'tooltip' => 'Ảnh có kích thước 128 x 106',
                                        'value' => 'promote'
                                    ])
                                {{-- End Image banner --}}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <a class="btn btn-outline-primary mr-2" href="promote/list">Huỷ</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
                {{-- End Footer --}}
            </form>
        </div>
    </main>
@endsection

@section('js')
    <script src="{{asset('/assets/js/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('/assets/js/custom/apps/promote/promote.js')}}"></script>
@endsection
