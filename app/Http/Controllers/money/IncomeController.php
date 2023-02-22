<?php

namespace App\Http\Controllers\money;

use App\DataTables\money\IncomeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\money\Income\IncomeFormRequest;
use App\Models\money\Income;
use App\Models\money\IncomeCategory;
use App\Traits\DeleteMultipleTrait;
use App\Traits\DeleteTrait;
use App\Traits\LogShowTrait;
use App\Traits\LogViewTrait;
use App\Traits\StatusActiveTrait;
use App\Traits\StatusBlockTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{
    use DeleteTrait, DeleteMultipleTrait, StatusActiveTrait, StatusBlockTrait, LogShowTrait, LogViewTrait;

    private Income $income;
    private $name = 'income';

    public function __construct(Income $income)
    {
        $this->income = $income;
    }

    public function index(IncomeDataTable $dataTable)
    {
        $category = DB::table('income_categories')->select('id', 'name')->get();
        return $dataTable->render('admin.money.income.list', [
            'title' => 'Danh sách thu nhập',
            'category' => $category
        ]);
    }

    public function store(IncomeFormRequest $request)
    {
        try {
            $input = $request->input();
            $input['received_date'] = $request->date;
            $input['income_cate'] = $request->cate;
            $input['description'] = [
                'type' => $this->check_payment_method($request->payment_method_type, $request->bank_name),
                'bank' => $request->bank_name,
                'account' => $request->account,
                'name' => $request->name,
                'note' => $request->note
            ];
            Income::create($input);
            return response()->json(['code' => 200, 'message' => 'success'], 200);

        } catch (Exception $err) {
            Log::error($err->getMessage() . ' Line: ' . $err->getLine());
            return response()->json(['code' => 500, 'message' => 'fail'], 500);
        }
    }

    public function show(Income $id): JsonResponse
    {
       $id['category'] = IncomeCategory::select('name')->where('id', $id->income_cate)->get();
       $id['title'] = 'Income';
        return response()->json($id);
    }

    public function update(Income $id, IncomeFormRequest $request): JsonResponse
    {
        try {
            $input = $request->input();
            $input['received_date'] = $request->date;
            $input['income_cate'] = $request->cate;
            $input['description'] = [
                'type' => $this->check_payment_method($request->payment_method_type, $request->bank_name),
                'bank' => $request->bank_name,
                'account' => $request->account,
                'name' => $request->name,
                'note' => $request->note
            ];

            $id->fill($input);
            $id->save();
            return response()->json(['code' => 200, 'message' => 'success'], 200);

        } catch (Exception $err) {
            Log::error($err->getMessage() . ' Line: ' . $err->getLine());
            return response()->json(['code' => 500, 'message' => 'fail'], 500);
        }
    }

    public function destroy(Income $id): JsonResponse
    {
        return $this->deleteTrait($id);
    }

    // Xoá nhiều bản ghi cùng lúc
    public function deleteMultiple(): JsonResponse
    {
        return $this->deleteMultipleTrait($this->income, $this->name);
    }

    private function check_payment_method($method, $bank): string
    {
        switch ($method) {
            case ('E-Cash'):
                $check_e_cash = in_array($bank, config('bank.vi_dien_tu'));
                if ($check_e_cash) {
                    $method = 'E-Cash';
                }
                break;
            case ('Transfer'):
                $check_bank = in_array($bank, config('bank.bank_name'));
                if ($check_bank) {
                    $method = 'Transfer';
                }
                break;
            case ('Cash'):
                $method = 'Cash';
                break;
            default:
                $method = 'Other';
                break;
        }

        return $method;
    }
}
