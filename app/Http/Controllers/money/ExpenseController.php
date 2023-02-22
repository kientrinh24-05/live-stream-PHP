<?php

namespace App\Http\Controllers\money;

use App\DataTables\money\ExpenseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\money\Expense\ExpenseFormRequest;
use App\Models\money\Expense;
use App\Models\money\ExpenseCategory;
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

class ExpenseController extends Controller
{
    use DeleteTrait, DeleteMultipleTrait, StatusActiveTrait, StatusBlockTrait, LogShowTrait, LogViewTrait;

    private Expense $expense;
    private $name = 'expense';

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    public function index(ExpenseDataTable $dataTable)
    {
        $category = DB::table('expense_categories')->select('id', 'name')->get();
        return $dataTable->render('admin.money.expense.list', [
            'title' => 'Danh sách thanh toán chi phí',
            'category' => $category
        ]);
    }

    public function store(ExpenseFormRequest $request): JsonResponse
    {
        try {
            $input = $request->input();
            $input['payment_date'] = $request->date;
            $input['expense_cate'] = $request->cate;
            $input['description'] = [
                'type' => $this->check_payment_method($request->payment_method_type, $request->bank_name),
                'bank' => $request->bank_name,
                'account' => $request->account,
                'name' => $request->name,
                'note' => $request->note
            ];
            Expense::create($input);
            return response()->json(['code' => 200, 'message' => 'success'], 200);

        } catch (Exception $err) {
            Log::error($err->getMessage() . ' Line: ' . $err->getLine());
            return response()->json(['code' => 500, 'message' => 'fail'], 500);
        }
    }

    public function show(Expense $id): JsonResponse
    {
        $id['category'] = ExpenseCategory::select('name')->where('id', $id->expense_cate)->get();
        $id['title'] = 'Expense';
        return response()->json($id);
    }

    public function update(Expense $id, ExpenseFormRequest $request): JsonResponse
    {
        try {
            $input = $request->input();
            $input['payment_date'] = $request->date;
            $input['expense_cate'] = $request->cate;
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

    public function destroy(Expense $id): JsonResponse
    {
        return $this->deleteTrait($id);
    }

    // Xoá nhiều bản ghi cùng lúc
    public function deleteMultiple(): JsonResponse
    {
        return $this->deleteMultipleTrait($this->expense, $this->name);
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
