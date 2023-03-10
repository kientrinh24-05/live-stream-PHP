<?php

namespace App\DataTables\members;

use App\Helpers\Helper;
use App\Http\Requests\Search\STaskTagRequest;
use App\Traits\GetCountTable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TaskTagDataTable extends DataTable
{
    use GetCountTable;

    protected $fastExcel = true;
    protected $fastExcelCallback = false;

    public function dataTable(STaskTagRequest $taskTagRequest, $query)
    {
        $dem = $this->getCountTable('task_tags', '', '', '', 'name', '');
        $count = $dem->count();

        if ($count == 0) {
            $count = "0";
        }

        return datatables()
            ->queryBuilder($query)
            ->filter(function ($query) {
                if (request('datatableSearch') != '') {
                    $query->where('name', 'like', "%" . request('datatableSearch') . "%");
                }
                if (request('start_date') != '' && request('end_date') != '' && request('end_date') >= request('start_date')) {
                    $query->whereBetween('task_tags.created_at', [request('start_date') . " 00:00:00", request('end_date') . " 23:59:59"]);
                }
            })
            ->editColumn('', function ($row) {
                return Helper::checkbox($row->id);
            })
            ->addColumn('action', function ($row) {
                return '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-sm btn-white action_edit">
                        <i class="tio-edit"></i> Edit</a>
                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm action_delete"
                        data-url="user/task/tag/destroy/'.$row->id.'"><i class="tio-delete-outlined"></i> Delete</a>';
            })
            ->setFilteredRecords($count)
            ->setTotalRecords($count)
            ->skipTotalRecords()
            ->rawColumns(['', 'action']);
    }

    public function query(): Builder
    {
        return DB::table('task_tags')->orderBy('id', 'desc');
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->pageLength(10)
            ->searching(false)
            ->ajax([
                'url' => 'user/task/tag/list',
                'type' => 'GET',
                'data' => 'function(d) {
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
                    toastr.error(errorsHtml, "T??m ki???m l???i!");
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
            Column::make('name')->title('T??n th???')->orderable(false)->searchable(false),
            Column::make('created_at')->addClass('text-center')->searchable(false),
            Column::make('updated_at')->addClass('text-center')->searchable(false)->orderable(false),
            Column::computed('action')->addClass('text-center')->exportable(false)->printable(false)->searchable(false),
        ];
    }

    protected function filename()
    {
        return 'TaskTag_' . date('YmdHis');
    }
}
