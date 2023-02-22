<?php

namespace App\Http\Controllers\money;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ReportMoneyController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $from = now()->firstOfMonth();
            $to = now()->endOfMonth();

            if (request('start') && request('end')) {
                $from = Carbon::parse(request('start'));
                $to = Carbon::parse(request('end') . " 23:59:59");
            }

            // Danh sách thu nhập, chi phí chi tiết
            $expensesList = $this->list_detail($this->db_table_expense($from, $to), 'expense_cate', 'payment_date');
            $incomesList = $this->list_detail($this->db_table_income($from, $to), 'income_cate', 'received_date');

            // Tổng thu nhập và chi phí
            $expensesTotal = $this->sum_vnd($this->db_table_expense($from, $to));
            $incomesTotal = $this->sum_vnd($this->db_table_income($from, $to));

            // Lợi nhuận
            $profit = $incomesTotal - $expensesTotal;

            // Danh sách thu nhập, chi phí theo loại
            $groupedExpenses = $this->list_type_group_expense($this->db_table_expense($from, $to));
            $groupedIncomes = $this->list_type_group_income($this->db_table_income($from, $to));

            // Check số ngày chênh lệch giữa 2 time
            $diffDay = $from->diffInDays($to);

            // Kiểm tra tháng và năm có trùng nhau không
            $from->format('Y') != $to->format('Y') ? $diffMonth = 2 : ($from->format('m/Y') != $to->format('m/Y') ? $diffMonth = 1 : $diffMonth = 0);

            // Tạo dữ liệu biểu đồ Line
            $chart_line_expense = $this->update_chart($this->db_table_expense($from, $to), 'payment_date', $diffDay);
            $chart_line_income = $this->update_chart($this->db_table_income($from, $to), 'received_date', $diffDay);

            if ($diffDay == 0 && $diffMonth == 0) {
                $axis = range(0, 23);
            } elseif ($diffDay > 0 && $diffDay <= 31 && $diffMonth == 0) {
                $axis = range($from->day, $to->day);
            } elseif ($diffDay > 0 && $diffDay <= 31 && $diffMonth == 1) {
                $period = CarbonPeriod::create($from, '1 day', $to);
                $axis = [];

                foreach ($period as $dt) {
                    $axis[] = $dt->format("d/m");
                }
            } elseif ($diffDay > 0 && $diffDay <= 31 && $diffMonth == 2) {
                $period = CarbonPeriod::create($from, '1 day', $to);
                $axis = [];

                foreach ($period as $dt) {
                    $axis[] = $dt->format("d/m/Y");
                }
            } else {
                $period = CarbonPeriod::create($from, '1 month', $to);
                $axis = [];

                foreach ($period as $dt) {
                    $axis[] = $dt->format("m/Y");
                }
            }

            // Lấy dữ liệu năm trước
            $fromSubYear = $from->subYear();
            $toSubYear = $to->subYear();
            $chart_line_expense_SubYear = $this->update_chart($this->db_table_expense($fromSubYear, $toSubYear), 'payment_date', $diffDay);
            $chart_line_income_SubYear = $this->update_chart($this->db_table_income($fromSubYear, $toSubYear), 'received_date', $diffDay);

            // Tạo Data biểu đồ Line
            $data_chart_expense = $this->convert_data_chart($chart_line_expense, $axis);
            $data_chart_income = $this->convert_data_chart($chart_line_income, $axis);
            $max_axis = max(array_merge($data_chart_expense, $data_chart_income));

            // Tạo Data biểu đồ Bar Expense
            $data_chart_expense_subYear = $this->convert_data_chart($chart_line_expense_SubYear, $axis);
            $max_axis_expense_subYear = max(array_merge($data_chart_expense, $data_chart_expense_subYear));

            // Tạo Data biểu đồ Bar Income
            $data_chart_income_subYear = $this->convert_data_chart($chart_line_income_SubYear, $axis);
            $max_axis_income_subYear = max(array_merge($data_chart_income, $data_chart_income_subYear));

            // Đổ giá trị biểu đồ
            $profitChart = $this->chart_line($data_chart_expense, $data_chart_income, $axis, $max_axis, $this->stepSize($max_axis));
            $expenseChart = $this->chart_bar_expense($data_chart_expense, $data_chart_expense_subYear, $axis, $max_axis_expense_subYear, $this->stepSize($max_axis_expense_subYear));
            $incomeChart = $this->chart_bar_income($data_chart_income, $data_chart_income_subYear, $axis, $max_axis_income_subYear, $this->stepSize($max_axis_income_subYear));

            // So sánh cùng kỳ năm trước
            $lastYearExpenses = $this->db_table_expense($fromSubYear, $toSubYear);
            $lastYearIncomes = $this->db_table_income($fromSubYear, $toSubYear);

            // Tổng cùng kỳ năm trước
            $lastYearExpensesTotal = $this->sum_vnd($lastYearExpenses);
            $lastYearIncomesTotal = $this->sum_vnd($lastYearIncomes);

            // Lợi nhuận cùng kỳ năm trước
            $lastYearProfit = $lastYearIncomesTotal - $lastYearExpensesTotal;

            // Chênh lệch giữa hiện tại và năm trước
            $differenceExpenses = $expensesTotal - $lastYearExpensesTotal;
            $differenceIncomes = $incomesTotal - $lastYearIncomesTotal;
            $differenceProfit = $profit - $lastYearProfit;

            // % tăng hoặc giảm so với năm trước
            $percentExpenses = $lastYearExpensesTotal === 0 ? 100 : ($differenceExpenses / $lastYearExpensesTotal) * 100;
            $percentIncomes = $lastYearIncomesTotal === 0 ? 100 : ($differenceIncomes / $lastYearIncomesTotal) * 100;
            $percentProfit = $lastYearProfit === 0 ? 100 : ($differenceProfit / $lastYearProfit) * 100;

            return response()->view('admin.money.content_report', [
                'profitChart' => $profitChart,
                'expenseChart' => $expenseChart,
                'incomeChart' => $incomeChart,
                'expenses' => $expensesList,
                'incomes' => $incomesList,
                'expensesSummary' => $groupedExpenses,
                'incomesSummary' => $groupedIncomes,
                'expensesTotal' => number_format($expensesTotal, 0, ',', '.'),
                'incomesTotal' => number_format($incomesTotal, 0, ',', '.'),
                'profit' => number_format($profit, 0, ',', '.'),
                'differenceExpenses' => number_format($differenceExpenses, 0, ',', '.'),
                'differenceIncomes' => number_format($differenceIncomes, 0, ',', '.'),
                'differenceProfit' => number_format($differenceProfit, 0, ',', '.'),
                'percentExpenses' => number_format($percentExpenses, 2, ',', '.'),
                'percentIncomes' => number_format($percentIncomes, 2, ',', '.'),
                'percentProfit' => number_format($percentProfit, 2, ',', '.')
            ]);
        } else {
            return view('admin.money.report', [
                'title' => 'Financial Reports'
            ]);
        }
    }

    public function db_table_expense($from, $to): Builder
    {
        return DB::table('expenses')->whereBetween('payment_date', [$from, $to]);
    }

    public function db_table_income($from, $to): Builder
    {
        return DB::table('incomes')->whereBetween('received_date', [$from, $to]);
    }

    public function sum_vnd($table)
    {
        return $table->sum('amount_vnd');
    }

    public function list_detail($table, $select1, $select2)
    {
        return $table->select('id', $select1, $select2, 'amount_vnd', 'amount_usd', 'rate')->orderBy($select2)->get();
    }

    public function list_type_group_expense($table)
    {
        return $table->Join('expense_categories', 'expense_cate', '=', 'expense_categories.id')
            ->select('expenses.expense_cate', 'expense_categories.name', DB::raw('sum(expenses.amount_vnd) AS expense_sum_type'))
            ->groupBy('expenses.expense_cate')->orderBy('expense_sum_type', 'desc')->get();

    }

    public function list_type_group_income($table)
    {
        return $table->Join('income_categories', 'income_cate', '=', 'income_categories.id')
            ->select('incomes.income_cate', 'income_categories.name', DB::raw('sum(incomes.amount_vnd) AS income_sum_type'))
            ->groupBy('incomes.income_cate')->orderBy('income_sum_type', 'desc')->get();
    }

    public function update_chart($table, $col_filter, $diffDay)
    {
        switch (request('type')) {
            case ('Today'):
            case ('Yesterday'):
                $chart = $this->show_hour($table, $col_filter);
                break;
            case ('Last 7 Days'):
            case ('Last 30 Days'):
            case ('Last Month'):
            case ('This Month'):
                $chart = $this->show_day($table, $col_filter);
                break;
            default:
                if ($diffDay == 0) {
                    $chart = $this->show_hour($table, $col_filter);
                } else if ($diffDay <= 31) {
                    $chart = $this->show_day($table, $col_filter);
                } else {
                    $chart = $table->select(DB::raw('sum(amount_vnd) as data'), DB::raw("DATE_FORMAT($col_filter, '%m/%Y') axis"))->groupBy('axis')->get();
                }

                break;
        }

        return $chart;
    }

    public function show_hour($table, $col_filter)
    {
        return $table->select(DB::raw('sum(amount_vnd) as data'), DB::raw("DATE_FORMAT($col_filter, '%H') axis"))->groupBy('axis')->get();
    }

    public function show_day($table, $col_filter)
    {
        return $table->select(DB::raw('sum(amount_vnd) as data'), DB::raw("DATE_FORMAT($col_filter, '%d/%m') axis"))->groupBy('axis')->get();
    }

    public function convert_data_chart($data, $axis): array
    {
        $finalResult = [];

        // Chuyển đổi object sang mảng
        $convert_data = $data->map(function ($obj) {
            return (array)$obj;
        })->toArray();

        foreach ($axis as $axi) {
            $axisSearch = array_search($axi, array_column($convert_data, 'axis'));
            if (is_numeric($axisSearch)) {
                $finalResult[] = $convert_data[$axisSearch]['data'];
            } else {
                $finalResult[] = 0;
            }
        }

        return $finalResult;
    }

    public function stepSize($max_axis): int
    {
        switch ($max_axis) {
            case ($max_axis > 0 && $max_axis <= 50000):
                $stepSize = 10000;
                break;
            case ($max_axis > 50000 && $max_axis <= 100000):
                $stepSize = 20000;
                break;
            case ($max_axis > 100000 && $max_axis <= 500000):
                $stepSize = 100000;
                break;
            case ($max_axis > 500000 && $max_axis <= 1000000):
                $stepSize = 200000;
                break;
            case ($max_axis > 1000000 && $max_axis <= 5000000):
                $stepSize = 1000000;
                break;
            case ($max_axis > 5000000 && $max_axis <= 10000000):
                $stepSize = 2000000;
                break;
            default:
                $stepSize = 0;
        }

        return $stepSize;
    }

    public function chart_line($data_expense, $data_income, $axis, $max_axis, $ticks): string
    {
        return '
            "type": "line",
            "data": {
                "labels": ' . json_encode($axis) . ',
                "datasets": [{
                    "label": "Income",
                    "data": ' . json_encode($data_income) . ',
                    "backgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"],
                    "borderColor": "#377dff",
                    "borderWidth": 2,
                    "pointRadius": 0,
                    "pointBorderColor": "#fff",
                    "pointBackgroundColor": "#377dff",
                    "pointHoverRadius": 0,
                    "hoverBorderColor": "#fff",
                    "hoverBackgroundColor": "#377dff"
                    },
                    {
                        "label": "Expenses",
                        "data": ' . json_encode($data_expense) . ',
                        "backgroundColor": ["rgba(0, 201, 219, 0)", "rgba(255, 255, 255, 0)"],
                        "borderColor": "#FF0000",
                        "borderWidth": 2,
                        "pointRadius": 0,
                        "pointBorderColor": "#fff",
                        "pointBackgroundColor": "#FF0000",
                        "pointHoverRadius": 0,
                        "hoverBorderColor": "#fff",
                        "hoverBackgroundColor": "#FF0000"
                    }
                ]
            },
            "options": {
                "gradientPosition": {"y1": 200},
                "scales": {
                    "yAxes": [{
                        "gridLines": {
                            "color": "#e7eaf3",
                            "drawBorder": false,
                            "zeroLineColor": "#e7eaf3"
                        },
                        "ticks": {
                            "min": 0,
                            ' . (($max_axis > 0 && $max_axis <= 10000000) ? '"stepSize": ' . $ticks . ',' : '') . '
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 10
                        }
                    }],
                    "xAxes": [{
                        "gridLines": {
                            "display": false,
                            "drawBorder": false
                        },
                        "ticks": {
                            "fontSize": 12,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 5
                        }
                    }]
                },
                "hover": {
                    "mode": "nearest",
                    "intersect": true
                }
            }';
    }

    public function chart_bar_expense($data_expense, $data_expense_last_year, $axis, $max_axis, $ticks): string
    {
        return '
            "type": "bar",
            "data": {
                "labels": ' . json_encode($axis) . ',
                "datasets": [{
                    "label": "Present",
                    "data": ' . json_encode($data_expense) . ',
                    "backgroundColor": "#377dff",
                    "borderColor": "#377dff",
                    "borderWidth": 2,
                    "pointRadius": 0,
                    "pointBorderColor": "#fff",
                    "pointBackgroundColor": "#377dff",
                    "pointHoverRadius": 0,
                    "hoverBorderColor": "#377dff",
                    "hoverBackgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"]
                    },
                    {
                        "label": "Last Year",
                        "data": ' . json_encode($data_expense_last_year) . ',
                        "backgroundColor": "#FF0000",
                        "borderColor": "#FF0000",
                        "borderWidth": 2,
                        "pointRadius": 0,
                        "pointBorderColor": "#fff",
                        "pointBackgroundColor": "#FF0000",
                        "pointHoverRadius": 0,
                        "hoverBorderColor": "#FF0000",
                        "hoverBackgroundColor": ["rgba(0, 201, 219, 0)", "rgba(255, 255, 255, 0)"]
                    }
                ]
            },
            "options": {
                "gradientPosition": {"y1": 200},
                "scales": {
                    "yAxes": [{
                        "gridLines": {
                            "color": "#e7eaf3",
                            "drawBorder": false,
                            "zeroLineColor": "#e7eaf3"
                        },
                        "ticks": {
                            "min": 0,
                           ' . (($max_axis > 0 && $max_axis <= 10000000) ? '"stepSize": ' . $ticks . ',' : '') . '
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 10
                        }
                    }],
                    "xAxes": [{
                        "gridLines": {
                            "display": false,
                            "drawBorder": false
                        },
                        "ticks": {
                            "fontSize": 12,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 5
                        }
                   }]
                },
                "tooltips": {
                    "enabled": true,
                    "mode": "index",
                    "intersect": false,
                    "postfix": " VND",
                    "bodySpacing": 10,
                    "xPadding" : 10,
                    "yPadding" : 10,
                    "caretPadding" : 10,
                    "titleFontColor": "#b9bdb3",
                    "titleAlign": "center",
                    "titleSpacing": 5,
                    "backgroundColor": "#132144"
                },
                "hover": {
                    "mode": "nearest",
                    "intersect": true
                }
            }
        ';
    }

    public function chart_bar_income($data_income, $data_income_last_year, $axis, $max_axis, $ticks): string
    {
        return '
            "type": "bar",
            "data": {
                "labels": ' . json_encode($axis) . ',
                "datasets": [{
                    "label": "Present",
                    "data": ' . json_encode($data_income) . ',
                    "backgroundColor": "#377dff",
                    "borderColor": "#377dff",
                    "borderWidth": 2,
                    "pointRadius": 0,
                    "pointBorderColor": "#fff",
                    "pointBackgroundColor": "#377dff",
                    "pointHoverRadius": 0,
                    "hoverBorderColor": "#377dff",
                    "hoverBackgroundColor": ["rgba(55, 125, 255, 0)", "rgba(255, 255, 255, 0)"]
                    },
                    {
                        "label": "Last Year",
                        "data": ' . json_encode($data_income_last_year) . ',
                        "backgroundColor": "#FF0000",
                        "borderColor": "#FF0000",
                        "borderWidth": 2,
                        "pointRadius": 0,
                        "pointBorderColor": "#fff",
                        "pointBackgroundColor": "#FF0000",
                        "pointHoverRadius": 0,
                        "hoverBorderColor": "#FF0000",
                        "hoverBackgroundColor": ["rgba(0, 201, 219, 0)", "rgba(255, 255, 255, 0)"]
                    }
                ]
            },
            "options": {
                "scales": {
                    "yAxes": [{
                        "gridLines": {
                            "color": "#e7eaf3",
                            "drawBorder": false,
                            "zeroLineColor": "#e7eaf3"
                        },
                        "ticks": {
                            "beginAtZero": true,
                           ' . (($max_axis > 0 && $max_axis <= 10000000) ? '"stepSize": ' . $ticks . ',' : '') . '
                            "fontSize": 12,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 10,
                            "postfix": "$"
                        }
                    }],
                    "xAxes": [{
                        "gridLines": {
                            "display": false,
                            "drawBorder": false
                        },
                        "ticks": {
                            "fontSize": 12,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 5
                        }
                    }]
                },
                "tooltips": {
                    "enabled": true,
                    "mode": "index",
                    "intersect": false,
                    "postfix": " VND",
                    "bodySpacing": 10,
                    "xPadding" : 10,
                    "yPadding" : 10,
                    "caretPadding" : 10,
                    "titleFontColor": "#b9bdb3",
                    "titleAlign": "center",
                    "titleSpacing": 5,
                    "backgroundColor": "#132144"
                },
                "hover": {
                    "mode": "nearest",
                    "intersect": true
                }
            }
        ';
    }

    public function invoice($id): JsonResponse
    {
        $from = now()->firstOfMonth();
        $to = now()->endOfMonth();

        if (request('start') && request('end')) {
            $from = Carbon::parse(request('start'));
            $to = Carbon::parse(request('end') . " 23:59:59");
        }

        $data = DB::table('expenses')
            ->select('id', 'payment_date', 'amount_vnd', 'amount_usd', 'rate', 'description->type as type', 'description->note as note')
            ->where('expense_cate', $id)
            ->whereBetween('payment_date', [$from, $to])
            ->orderBy('payment_date')
            ->get();

        $sum = DB::table('expenses')->select(DB::raw('sum(amount_vnd) as sum_vnd'), DB::raw('sum(amount_usd) as sum_usd'))
            ->where('expense_cate', $id)
            ->whereBetween('payment_date', [$from, $to])
            ->get();

        $cate = DB::table('expense_categories')->select('name')->where('id', $id)->get();


        return response()->json([
            'title' => 'Expense',
            'money' => $data,
            'total' => $sum,
            'cate' => $cate,
            'from' => $from->format('d/m/Y'),
            'to' => $to->format('d/m/Y')
        ]);
    }

    public function receipt($id): JsonResponse
    {
        $from = now()->firstOfMonth();
        $to = now()->endOfMonth();

        if (request('start') && request('end')) {
            $from = Carbon::parse(request('start'));
            $to = Carbon::parse(request('end') . " 23:59:59");
        }
        $data = DB::table('incomes')
            ->select('id', 'received_date', 'amount_vnd', 'amount_usd', 'rate', 'description->type as type', 'description->note as note')
            ->where('income_cate', $id)
            ->whereBetween('received_date', [$from, $to])
            ->orderBy('received_date')
            ->get();

        $sum = DB::table('incomes')->select(DB::raw('sum(amount_vnd) as sum_vnd'), DB::raw('sum(amount_usd) as sum_usd'))
            ->where('income_cate', $id)
            ->whereBetween('received_date', [$from, $to])
            ->get();

        $cate = DB::table('income_categories')->select('name')->where('id', $id)->get();


        return response()->json([
            'title' => 'Income',
            'money' => $data,
            'total' => $sum,
            'cate' => $cate,
            'from' => $from->format('d/m/Y'),
            'to' => $to->format('d/m/Y')
        ]);
    }
}
