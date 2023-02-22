<?php

namespace App\DataTables\money;

use App\Helpers\Helper;
use App\Http\Requests\Search\SIncomeRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IncomeDataTable extends DataTable
{
    protected $fastExcel = true;
    protected $fastExcelCallback = false;

    public function dataTable(SIncomeRequest $incomeRequest, $query)
    {
        $dem = $this->getCountTable();
        $count = $dem->count();

        if ($count == 0) {
            $count = "0";
        }

        return datatables()
            ->queryBuilder($query)
            ->filter(function ($query) {
                if (request('filter1') != '') {
                    $query->whereBetween('payment_date', [request('filter1') . " 00:00:00", request('filter1') . " 23:59:59"]);
                }
                if (request('filter2') != '' && request('filter3') != '' && request('filter2') <= request('filter3')) {
                    request('unit') == 'vnd' ? $amount = 'amount_vnd' : $amount = 'amount_usd';
                    $query->whereBetween($amount, [request('filter2'), request('filter3')]);
                }
                if (request('datatableSearch') != '') {
                    $query->where('income_categories.name', 'like', "%" . request('datatableSearch') . "%");
                }
                if (request('start_date') != '' && request('end_date') != '' && request('end_date') >= request('start_date')) {
                    $query->whereBetween('incomes.created_at', [request('start_date') . " 00:00:00", request('end_date') . " 23:59:59"]);
                }
            })
            ->editColumn('', function ($row) {
                return Helper::checkbox($row->id);
            })
            ->editColumn('amount_vnd', function ($row) {
                return number_format($row->amount_vnd, 0, ',', '.');
            })
            ->editColumn('amount_usd', function ($row) {
                return number_format($row->amount_usd, 2, ',', '.');
            })
            ->editColumn('rate', function ($row) {
                return number_format($row->rate, 0, ',', '.');
            })
            //->editColumn('description', '{!! Str::limit($description, 30) !!}')
            ->editColumn('description', function ($row) {
                $note = json_decode($row->description, true);
                return Str::limit($note['note'], 20);
            })
            ->editColumn('name', '{!! Str::limit($name, 40) !!}')
            ->addColumn('action', function ($row) {
                return '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-white receipt">
                        <i class="tio-receipt-outlined"></i></a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-white action_edit">
                        <i class="tio-edit"></i></a>
                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm action_delete"
                        data-url="transaction/expense/destroy/' . $row->id . '"><i class="tio-delete-outlined"></i></a>';
            })
            ->setFilteredRecords($count)
            ->setTotalRecords($count)
            ->skipTotalRecords()
            ->rawColumns(['', 'amount_vnd', 'amount_usd', 'rate', 'description', 'action']);
    }

    public function query(): Builder
    {
        return DB::table('incomes')
            ->join('income_categories', 'income_cate', '=', 'income_categories.id')
            ->select('income_categories.name', 'incomes.*')
            ->orderBy('id', 'desc');
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->pageLength(10)
            ->searching(false)
            ->ajax([
                'url' => 'transaction/income/list',
                'type' => 'GET',
                'data' => 'function(d) {
                     d.filter1 = $("#filter1").val();
                     d.filter2 = $("#filter2").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, "");
                     d.filter3 = $("#filter3").val().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\D/g, "");
                     d.unit = $("#unit").val();
                     d.start_date = $("#start_date").val();
                     d.end_date = $("#end_date").val();
                     d.datatableSearch = $("#datatableSearch").val();
                }',
                'error' => 'function (data) {
                    let errors = data.responseJSON;
                    let errorsHtml = "";
                    $.each(errors, function (key, value) {
                        errorsHtml += "<li>" + value[0] + "</li>";
                    });
                    toastr.error(errorsHtml, "Tìm kiếm lỗi!");
                    Swal.fire("Error!", errorsHtml, "error");
                    resetInput();
                    $("#datatable_processing").hide();
            }'])
            ->buttons(
                Button::make('copy'),
                Button::make('print'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf')
            );
    }

    protected function getColumns(): array
    {
        return [
            Column::make('id')->hidden(),
            Column::checkbox(),
            Column::make('received_date')->title('Thời gian thu nhập')->orderable(false)->searchable(false),
            Column::make('name')->title('Loại thu nhập')->orderable(false)->searchable(false),
            Column::make('amount_vnd')->title('Số tiền (vnđ)')->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('amount_usd')->title('Số tiền (usd)')->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('rate')->title('Tỉ giá usd')->addClass('text-center')->orderable(false)->searchable(false),
            Column::make('description')->title('Ghi chú')->searchable(false)->orderable(false),
            Column::make('created_at')->addClass('text-center')->searchable(false),
            Column::make('updated_at')->addClass('text-center')->searchable(false)->orderable(false),
            Column::computed('action')->addClass('text-center')->exportable(false)->printable(false)->searchable(false),
        ];
    }

    protected function filename()
    {
        return 'Income_' . date('YmdHis');
    }

    public function getCountTable(): Builder
    {
        $to = request('end_date');
        $from = request('start_date');
        $filter1 = request('filter1');
        $filter2 = request('filter2');
        $filter3 = request('filter3');
        $search = request('datatableSearch');

        $news = DB::table('incomes');

        if (!empty(request()->input())) {
            if ($filter1 != '') {
                $news->whereBetween('received_date', [$filter1 . " 00:00:00", $filter1 . " 23:59:59"]);
            }
            if ($filter2 != '' && $filter3 != '' && $filter2 <= $filter3) {
                request('unit') == 'vnd' ? $amount = 'amount_vnd' : $amount = 'amount_usd';
                $news->whereBetween($amount, [$filter2, $filter3]);
            }
            if ($search != '') {
                $news->join('income_categories', 'income_cate', '=', 'income_categories.id')
                    ->where('income_categories.name', 'like', "%" . $search . "%");
            }
            if ($from != '' && $to != '' && $to >= $from) {
                $news->whereBetween('incomes' . '.created_at', [$from . " 00:00:00", $to . " 23:59:59"]);
            }
        }

        return $news;
    }
}
