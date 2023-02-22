<!-- Stats -->
<div class="row mb-3 mb-lg-5">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body">
                <img class="avatar avatar-xl avatar-4by3 mb-4" src="assets\svg\illustrations\click.svg"
                     alt="Total Expenses">
                <small class="text-cap">Total Expenses (vnđ)</small>
                <span class="d-block display-4 text-dark mb-2">{{$expensesTotal}}</span>

                <div class="row">
                    <div class="col text-right">
                        @if($differenceExpenses > 0)
                            <span class="d-block font-weight-bold text-primary">
                                <i class="tio-trending-up"></i> {{$percentExpenses}}%
                            </span>
                        @else
                            <span class="d-block font-weight-bold text-danger">
                                <i class="tio-trending-down"></i> {{$percentExpenses}}%
                            </span>
                        @endif
                    </div>

                    <div class="col column-divider text-left">
                        @if($differenceExpenses > 0)
                            <span class="d-block font-weight-bold text-primary">+ {{$differenceExpenses}}</span>
                        @else
                            <span class="d-block font-weight-bold text-danger">{{$differenceExpenses}}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 column-divider-lg">
        <div class="d-lg-none">
            <hr class="my-5">
        </div>

        <!-- Card -->
        <div class="card text-center">
            <div class="card-body">
                <img class="avatar avatar-xl avatar-4by3 mb-4" src="assets\svg\illustrations\presenting.svg"
                     alt="Total Incomes">
                <small class="text-cap">Total Incomes (vnđ)</small>
                <span class="d-block display-4 text-dark mb-2">{{$incomesTotal}}</span>

                <div class="row">
                    <div class="col text-right">
                        @if($differenceIncomes > 0)
                            <span class="d-block font-weight-bold text-primary">
                                <i class="tio-trending-up"></i> {{$percentIncomes}}%
                            </span>
                        @else
                            <span class="d-block font-weight-bold text-danger">
                                <i class="tio-trending-down"></i> {{$percentIncomes}}%
                            </span>
                        @endif
                    </div>

                    <div class="col column-divider text-left">
                        @if($differenceIncomes > 0)
                            <span class="d-block font-weight-bold text-primary">+ {{$differenceIncomes}}</span>
                        @else
                            <span class="d-block font-weight-bold text-danger">{{$differenceIncomes}}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 column-divider-lg">
        <div class="d-lg-none">
            <hr class="my-5">
        </div>

        <!-- Card -->
        <div class="card text-center">
            <div class="card-body">
                <img class="avatar avatar-xl avatar-4by3 mb-4" src="assets\svg\illustrations\hi-five.svg"
                     alt="Total Profit">
                <small class="text-cap">Total Profit (vnđ)</small>
                @if($profit > 0)
                    <span class="d-block display-4 text-primary mb-2">{{$profit}}</span>
                @else
                    <span class="d-block display-4 text-danger mb-2">{{$profit}}</span>
                @endif

                <div class="row">
                    <div class="col text-right">
                        @if($differenceProfit > 0)
                            <span class="d-block font-weight-bold text-primary">
                                <i class="tio-trending-up"></i> {{$percentProfit}}%
                            </span>
                        @else
                            <span class="d-block font-weight-bold text-danger">
                                <i class="tio-trending-down"></i> {{$percentProfit}}%
                            </span>
                        @endif
                    </div>

                    <div class="col column-divider text-left">
                        @if($differenceProfit > 0)
                            <span class="d-block font-weight-bold text-primary">+ {{$differenceProfit}}</span>
                        @else
                            <span class="d-block font-weight-bold text-danger">{{$differenceProfit}}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Stats -->

<div class="card mb-3 mb-lg-5">
    <!-- Header -->
    <div class="card-header">
        <div class="col-lg-10 col-sm-auto">
            <h5 class="card-subtitle mb-0">
                Profit: {!! $profit > 0 ? '<span class="h3 ml-sm-2 text-primary">'.$profit.' VNĐ</span>' : '<span class="h3 ml-sm-2 text-danger">'.$profit.' VNĐ</span>' !!}
            </h5>
        </div>
        @if (Agent::isDesktop())
            <div class="col-lg-1 col-sm-auto">
                <span class="legend-indicator bg-primary"></span> Income
            </div>
            <div class="col-lg-1 col-sm-auto">
                <span class="legend-indicator bg-danger"></span> Expense
            </div>
        @endif
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="card-body">
        <!-- Line Chart -->
        <div class="chartjs-custom" style="height: 18rem;">
            <canvas class="js-chart" data-hs-chartjs-options='{ {!! $profitChart !!} }'></canvas>
        </div>

        @if (Agent::isMobile())
            <div class="row justify-content-center mt-3">
                <div class="col-auto">
                    <span class="legend-indicator bg-primary"></span> Income
                </div>
                <div class="col-auto">
                    <span class="legend-indicator bg-danger"></span> Expense
                </div>
            </div>
    @endif
    <!-- End Line Chart -->
    </div>
    <!-- End Body -->
</div>
<!-- End Card -->

<div class="row">
    <div class="col-lg-3 mb-3 mb-lg-5" style="height: 360px;">
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <h5 class="card-subtitle mb-0">Expenses: <span
                        class="h4 ml-sm-2">{{$expensesTotal}} VNĐ</span></h5>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
                <!-- Bar Chart -->
                <div class="chartjs-custom" style="height: 14rem;">
                    <canvas class="js-chart chartjsLegend" id="expenseChart"
                            data-hs-chartjs-options='{ {!! $expenseChart !!} }'></canvas>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-auto">
                        <span class="legend-indicator bg-primary"></span> Present
                    </div>
                    <div class="col-auto">
                        <span class="legend-indicator bg-danger"></span> Last year
                    </div>
                </div>
                <!-- End Bar Chart -->
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
    </div>

    <div class="col-lg-5 mb-3 mb-lg-5" style="height: 360px;">
        <div class="card h-100">
            <!-- Header -->
            <div class="card-header justify-content-center">
                <h4 class="card-header-title">Expense type details</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body-height js-sticky-header">
                <!-- Table -->
                <div class="table-responsive">
                    <table
                        class="dataTable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="fix-align">ID Type</th>
                            <th scope="col">Type name</th>
                            <th scope="col" class="text-center">VNĐ</th>
                            <th scope="col" class="text-center">INVOICE</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($expensesSummary as $expense_type_sum)
                            <tr>
                                <td class="text-center">{{$expense_type_sum->expense_cate}}</td>
                                <td>{{$expense_type_sum->name}}</td>
                                <td class="text-center">{{number_format($expense_type_sum->expense_sum_type, 0, ',', '.')}}</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-white invoice" href="javascript:"
                                        data-id= {{$expense_type_sum->expense_cate}}>
                                        <i class="tio-receipt-outlined mr-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center p-4">
                                        <img class="mb-3" src="{{asset('assets/svg/illustrations/sorry.svg')}}"
                                             alt="No data to show" style="width: 7rem;">
                                        <p class="mb-0">No data to show</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>
            <!-- End Body -->
        </div>
    </div>

    <div class="col-lg-4 mb-3 mb-lg-5" style="height: 360px;">
        <div class="card h-100">
            <!-- Header -->
            <div class="card-header justify-content-center">
                <h4 class="card-header-title">Expense details</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body-height js-sticky-header">
                <!-- Table -->
                <div class="table-responsive">
                    <table
                        class="dataTable1 table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center">Type</th>
                            <th scope="col" class="text-center">Date</th>
                            <th scope="col" class="text-center">VNĐ</th>
                            <th scope="col" class="text-center">USD - RATE</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($expenses as $expense)
                            <tr class="text-center expense_detail" data-id="{{$expense->id}}">
                                <td>{{$expense->expense_cate}}</td>
                                <td>{{$expense->payment_date}}</td>
                                <td>{{number_format($expense->amount_vnd, 0, ',', '.') }}</td>
                                <td>{{number_format($expense->amount_usd, 2, ',', '.')}}
                                    - {{number_format($expense->rate, 0, ',', '.')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center p-4">
                                        <img class="mb-3" src="{{asset('assets/svg/illustrations/sorry.svg')}}"
                                             alt="No data to show" style="width: 7rem;">
                                        <p class="mb-0">No data to show</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>
            <!-- End Body -->
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row">
    <div class="col-lg-3 mb-3 mb-lg-5" style="height: 360px;">
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <h5 class="card-subtitle mb-0">Incomes: <span
                        class="h4 ml-sm-2">{{$incomesTotal}} VNĐ</span></h5>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body">
                <!-- Bar Chart -->
                <div class="chartjs-custom" style="height: 14rem;">
                    <canvas class="js-chart" data-hs-chartjs-options='{ {!! $incomeChart !!} }'></canvas>
                </div>

                <div class="row justify-content-center mt-3">
                    <div class="col-auto">
                        <span class="legend-indicator bg-primary"></span> Present
                    </div>
                    <div class="col-auto">
                        <span class="legend-indicator bg-danger"></span> Last year
                    </div>
                </div>
                <!-- End Bar Chart -->
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
    </div>

    <div class="col-lg-5 mb-3 mb-lg-5" style="height: 360px;">
        <div class="card h-100">
            <!-- Header -->
            <div class="card-header justify-content-center">
                <h4 class="card-header-title">Details of the type of income</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body-height js-sticky-header">
                <!-- Table -->
                <div class="table-responsive">
                    <table
                        class="dataTable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="fix-align">ID Type</th>
                            <th scope="col">Type name</th>
                            <th scope="col" class="text-center">VNĐ</th>
                            <th scope="col" class="text-center">INVOICE</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($incomesSummary as $income_type_sum)
                            <tr>
                                <td class="text-center">{{$income_type_sum->income_cate}}</td>
                                <td>{{$income_type_sum->name}}</td>
                                <td class="text-center">{{number_format($income_type_sum->income_sum_type, 0, ',', '.')}}</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-white receipt" href="javascript:"
                                       data-id="{{$income_type_sum->income_cate}}">
                                        <i class="tio-receipt-outlined mr-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center p-4">
                                        <img class="mb-3" src="{{asset('assets/svg/illustrations/sorry.svg')}}"
                                             alt="No data to show" style="width: 7rem;">
                                        <p class="mb-0">No data to show</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>
            <!-- End Body -->
        </div>
    </div>

    <div class="col-lg-4 mb-3 mb-lg-5" style="height: 360px;">
        <div class="card h-100">
            <!-- Header -->
            <div class="card-header justify-content-center">
                <h4 class="card-header-title">Income details</h4>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body-height js-sticky-header">
                <!-- Table -->
                <div class="table-responsive">
                    <table
                        class="dataTable1 table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center">Type</th>
                            <th scope="col" class="text-center">Date</th>
                            <th scope="col" class="text-center">VNĐ</th>
                            <th scope="col" class="text-center">USD - RATE</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($incomes as $income)
                            <tr class="text-center income_detail" data-id="{{$income->id}}">
                                <td>{{$income->income_cate}}</td>
                                <td>{{$income->received_date}}</td>
                                <td>{{number_format($income->amount_vnd, 0, ',', '.') }}</td>
                                <td>{{number_format($income->amount_usd, 2, ',', '.')}}
                                    - {{number_format($income->rate, 0, ',', '.')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center p-4">
                                        <img class="mb-3" src="{{asset('assets/svg/illustrations/sorry.svg')}}"
                                             alt="No data to show" style="width: 7rem;">
                                        <p class="mb-0">No data to show</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>
            <!-- End Body -->
        </div>
    </div>
</div>
<!-- End Row -->
