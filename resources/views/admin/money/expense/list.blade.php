@extends('admin.layout.index')
@section('content')
    <div id="content" role="main" class="main">
        <div class="content container-fluid">

            {{-- Page Header --}}
            @include('admin.layout.list.headerPageAjax', [
                        'breadcrumb_list' => 'expense/list',
                        'breadcrumb' => 'Expense',
                        'page' => 'List',
                        'pagetitle' => 'Danh sách chi phí',
                        'target' => 'showAddModal',
                        'action_title' => 'Add Expense'
                    ])
            {{-- End Page Header --}}

            {{-- Alert --}}
            @include('admin.layout.alert')
            {{-- End Alert --}}

            <form>
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-3 mb-lg-5">
                            {{-- Header --}}
                            <div class="card-header" id="search-filter">
                                <div class="row justify-content-between align-items-center flex-grow-1">

                                    @include('admin.layout.list.headerForm', ['headertitle' => 'List Expense','searchholder' => 'tên loại chi phí, ngân hàng, người nhận, số tài khoản, ghi chú'])

                                    {{-- Filters --}}
                                    <div class="hs-unfold mr-2">
                                        <a class="js-hs-unfold-invoker btn btn-white" href="javascript:"
                                           data-hs-unfold-options='{"target": "#FilterDropdown","type": "css-animation",
                                           "smartPositionOff": true}'><i class="tio-filter-list mr-1"></i>Filter
                                        </a>

                                        <div id="FilterDropdown" style="min-width: 25rem;"
                                             class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right dropdown-card card-dropdown-filter-centered">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-header-title">Filter Expense</h5>

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
                                                                <small class="text-cap mb-2">Tiền thanh toán</small>
                                                                <input type="text" id="filter2" name="filter2"
                                                                       class="form-control convert-number"
                                                                       placeholder="Số tiền"
                                                                       value="{{old('filter2')}}">
                                                            </div>

                                                            <div class="col-sm form-group">
                                                                <small class="text-cap mb-2">Đến số tiền</small>
                                                                <input type="text" id="filter3" name="filter3"
                                                                       class="form-control convert-number"
                                                                       placeholder="Đến khoảng"
                                                                       value="{{old('filter3')}}">
                                                            </div>

                                                            <div class="col-sm form-group col-sm-3">
                                                                <small class="text-cap mb-2">Đơn vị</small>
                                                                <select
                                                                    class="js-select2-custom js-datatable-filter custom-select"
                                                                    size="1" style="opacity: 0;" id="unit" name="unit"
                                                                    data-hs-select2-options='{"minimumResultsForSearch": "Infinity"}'>
                                                                    <option value="vnd" selected>VNĐ</option>
                                                                    <option value="usd">USD</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        @include('admin.layout.list.filter.filterDate')

                                                        <div class="form-row">
                                                            <div class="col-sm form-group">
                                                                <small class="text-cap mb-2">Thời gian thanh
                                                                    toán</small>
                                                                <div
                                                                    class="js-flatpickr flatpickr-custom input-group input-group-merge"
                                                                    id="dateExpense" data-hs-flatpickr-options='{"appendTo": "#dateExpense",
                                                                     "dateFormat": "Y-m-d","wrap": true}'>
                                                                    <div class="input-group-prepend" data-toggle="">
                                                                        <div class="input-group-text">
                                                                            <i class="tio-calendar-month"></i>
                                                                        </div>
                                                                    </div>

                                                                    <input type="text" id="filter1" name="filter1"
                                                                           class="flatpickr-custom-form-control form-control"
                                                                           placeholder="Ngày thanh toán chi phí"
                                                                           data-input="" value="{{old('filter1')}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @include('admin.layout.list.filter.actionApply')
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
                                                                     'col2' => 'Thời gian thanh toán',
                                                                     'col3' => 'Loại chi phí',
                                                                     'col4' => 'Số tiền (vnđ)',
                                                                     'col5' => 'Số tiền (usd)',
                                                                     'col6' => 'Tỉ giá (usd)',
                                                                     'col7' => 'Ghi chú',
                                                                     'col8' => 'Create_at',
                                                                     'col9' => 'Update_at',
                                                                     'col10' => 'Action'
                                                     ])
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

            {{-- Add Expense Modal --}}
            @include('admin.money.expense.add')
            {{-- End Add Expense Modal --}}

            {{-- Update Expense Modal --}}
            @include('admin.money.expense.edit')
            {{-- End Update Expense Modal --}}

            {{-- Invoice Modal --}}
            @include('admin.money.expense.invoice')
            {{-- End Invoice Modal --}}
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('vendor/datatables/buttons.server-side.js')}}"></script>
{{$dataTable->scripts()}}
<script src="{{asset('/assets/js/action.js')}}"></script>
<script src="{{asset('/assets/js/custom/money/trans_detail.js')}}"></script>
<script src="{{asset('/assets/js/custom/money/expense/expense.js')}}"></script>
@if (Agent::isMobile())
    @include('admin.layout.mobile')
@endif
@endpush


