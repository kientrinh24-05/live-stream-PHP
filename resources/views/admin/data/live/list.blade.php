@extends('admin.layout.index')
@section('content')
    <div id="content" role="main" class="main">
        <div class="content container-fluid">

            {{-- Page Header --}}
            @include('admin.layout.list.headerPage', [
                         'breadcrumb_list' => 'data/live/list',
                         'breadcrumb' => 'Data Live',
                         'page' => 'List',
                         'pagetitle' => 'Data Center',
                         'linkadd' => 'data/live/add',
                         'add' => 'Import Live Data'
                     ])
            {{-- End Page Header --}}

            {{-- Alert --}}
            @include('admin.layout.alert')
            {{-- End Alert --}}

            <form>
                @csrf
                <div class="row" id="tableReport" style="display: none">
                    <div class="col-lg-12">
                        <div class="card mb-3 mb-lg-5">
                            {{-- Header --}}
                            <div class="card-header">
                                <div class="row justify-content-between align-items-center flex-grow-1">
                                    <div class="col-sm mb-3 mb-sm-0">
                                        <h3 class="card-header-title text-center">Báo cáo tổng quan</h3>
                                    </div>
                                </div>
                            </div>
                            {{-- End Header --}}

                            {{-- Table --}}
                            <div class="table-responsive datatable-custom">
                                <table
                                       class="table table-border table-hover table-thead-bordered table-nowrap table-align-middle card-table text-center">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Tổng số ngày mở live</th>
                                        <th>Tổng thời gian live (h)</th>
                                        <th>Số ngày live hiệu lực</th>
                                        <th>Quà tăng mới</th>
                                        <th>Người hâm mộ mới</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr class="text-primary">
                                        <td id="sumDay">0</td>
                                        <td id="sumLiveTime">0.00</td>
                                        <td id="sumLiveDayActive">0</td>
                                        <td id="sumIncome">0</td>
                                        <td id="sumFan">0</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- End Table --}}

                            <div class="card-footer"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3 mb-lg-5">
                            {{-- Header --}}
                            <div class="card-header" id="search-filter">
                                <div class="row justify-content-between align-items-center flex-grow-1">

                                    @include('admin.layout.list.headerForm', [
                                            'headertitle' => 'List Data Live',
                                            'searchholder' => 'Team or Nick name or ID in app'
                                    ])

                                    {{-- Filters --}}
                                    <div class="hs-unfold mr-2">
                                        <a class="js-hs-unfold-invoker btn btn-white" href="javascript:;"
                                           data-hs-unfold-options='{"target": "#FilterDropdown","type": "css-animation",
                                           "smartPositionOff": true}'><i class="tio-filter-list mr-1"></i>Filter
                                        </a>

                                        <div id="FilterDropdown" style="min-width: 25rem;"
                                             class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right dropdown-card card-dropdown-filter-centered">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-header-title">Filter Data Live</h5>

                                                    {{-- Toggle Button--}}
                                                    <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-secondary ml-2"
                                                       href="javascript:" data-hs-unfold-options='{"target": "#FilterDropdown",
                                                       "type": "css-animation","smartPositionOff": true}'>
                                                        <i class="tio-clear tio-lg"></i>
                                                    </a>
                                                    {{-- End Toggle Button--}}
                                                </div>

                                                <div class="card-body">
                                                    <form id="filter">
                                                        <div class="form-row">
                                                            <div class="col-sm form-group">
                                                                <small class="text-cap mb-2">Thể loại</small>
                                                                <select class="js-select2-custom custom-select" size="1"
                                                                        style="opacity: 0;" name="filter1" id="filter1"
                                                                        data-hs-select2-options='{"minimumResultsForSearch": "Infinity"}'>
                                                                    <option value="">All Category</option>
                                                                    @foreach($menus as $cate)
                                                                        <option
                                                                            value="{{ $cate->id }}">{{ $cate->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-sm form-group">
                                                                <small class="text-cap mb-2">Ứng dụng</small>
                                                                <select class="js-select2-custom custom-select" size="1"
                                                                        style="opacity: 0;" name="filter2" id="filter2"
                                                                        data-hs-select2-options='{"minimumResultsForSearch": "Infinity"}'>
                                                                    <option value="">All Application</option>
                                                                    @foreach($applications as $app)
                                                                        <option
                                                                            value="{{$app->id}}">{{$app->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-sm form-group">
                                                                <small class="text-cap mb-2">Start Date</small>
                                                                <div
                                                                    class="js-flatpickr flatpickr-custom input-group input-group-merge"
                                                                    id="dateStart" data-hs-flatpickr-options='{"appendTo": "#dateStart",
                                                                     "dateFormat": "Y/m/d","wrap": true}'>
                                                                    <div class="input-group-prepend" data-toggle="">
                                                                        <div class="input-group-text">
                                                                            <i class="tio-calendar-month"></i>
                                                                        </div>
                                                                    </div>

                                                                    <input type="text" id="start_date" name="start_date"
                                                                           class="flatpickr-custom-form-control form-control"
                                                                           placeholder="Ngày bắt đầu" data-input=""
                                                                           value="{{old('start_date')}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm form-group">
                                                                <small class="text-cap mb-2">End Date</small>
                                                                <div
                                                                    class="js-flatpickr flatpickr-custom input-group input-group-merge"
                                                                    id="dateEnd" data-hs-flatpickr-options='{"appendTo": "#dateEnd",
                                                                    "dateFormat": "Y/m/d","wrap": true}'>
                                                                    <div class="input-group-prepend" data-toggle="">
                                                                        <div class="input-group-text">
                                                                            <i class="tio-calendar-month"></i>
                                                                        </div>
                                                                    </div>

                                                                    <input type="text" id="end_date" name="end_date"
                                                                           class="flatpickr-custom-form-control form-control"
                                                                           placeholder="Ngày kết thúc" data-input=""
                                                                           value="{{old('end_date')}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-sm form-group">
                                                                <small class="text-cap mb-2">Username</small>
                                                                <select
                                                                    class="js-select2-custom js-datatable-filter custom-select"
                                                                    size="1" style="opacity: 0;" id="filter3"
                                                                    name="filter3"
                                                                    data-hs-select2-options='{"searchInputPlaceholder": "Tìm kiếm username"}'>
                                                                    <option value="">Tất cả người dùng</option>
                                                                    @foreach($users as $user)
                                                                        <option
                                                                            value="{{$user->id}}">{{$user->username}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="col-sm form-group">
                                                                <a class="btn btn-block btn-soft-success" id="reset">
                                                                    <i class="tio-refresh"></i> Reset
                                                                </a>
                                                            </div>
                                                            <div class="col-sm form-group">
                                                                <a class="js-hs-unfold-invoker btn btn-block btn-primary apply"
                                                                   href="javascript:;" data-hs-unfold-options='{
                                                                    "target": "#slideFilterDropdown","type": "css-animation",
                                                                    "smartPositionOff": true}'>Apply</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Filters --}}

                                    {{-- Unfold Columns --}}
                                    <div class="hs-unfold">
                                        <a class="js-hs-unfold-invoker btn btn-white" href="javascript:"
                                           data-hs-unfold-options='{"target": "#showHideDropdown", "type": "css-animation"}'>
                                            <i class="tio-table mr-1"></i> Columns
                                        </a>

                                        <div id="showHideDropdown" style="width: 15rem;"
                                             class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card">
                                            <div class="card card-sm">
                                                <div class="card-body">
                                                    @include('admin.layout.list.column.column', [
                                                                'col2' => 'Username',
                                                                'col3' => 'Category',
                                                                'col4' => 'App',
                                                                'col5' => 'ID in app',
                                                                'col6' => 'Team',
                                                                'col7' => 'Ngày cast',
                                                                'col8' => 'Kết quả',
                                                                'col9' => 'Lương cứng',
                                                                'col10' => 'Created_at'

                                                    ])
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="mr-2">Updated_at</span>
                                                        <label class="toggle-switch toggle-switch-sm" for="col11">
                                                            <input type="checkbox" class="toggle-switch-input"
                                                                   id="col11" checked="">
                                                            <span class="toggle-switch-label"><span
                                                                    class="toggle-switch-indicator"></span></span>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Unfold Columns --}}
                                </div>
                            </div>
                            {{-- End Header --}}

                            {{-- Table --}}
                            <div class="table-responsive datatable-custom ">
                                {{$dataTable->table()}}
                            </div>
                            {{-- End Table --}}

                            {{-- Footer --}}
                            @include('admin.layout.list.tableFooter10')
                            {{-- End Footer --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{asset('vendor/datatables/buttons.server-side.js')}}"></script>
    {{$dataTable->scripts()}}
    <script src="{{asset('/assets/js/action.js')}}"></script>
    <script src="{{asset('/assets/js/custom/data/live.js')}}"></script>
    @if (Agent::isMobile())
        @include('admin.layout.mobile')
    @endif
@endpush


