<?php

namespace App\Http\Controllers\members;

use App\DataTables\members\BankDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\members\Bank\BankFormRequest;
use App\Http\Services\members\Bank\BankService;
use App\Models\members\Bank;
use App\Traits\DeleteMultipleTrait;
use App\Traits\DeleteTrait;
use App\Traits\LogShowTrait;
use App\Traits\LogViewTrait;
use Illuminate\Http\JsonResponse;

class BankController extends Controller
{
    use DeleteMultipleTrait, DeleteTrait, LogViewTrait, LogShowTrait;

    private BankService $bankService;
    private Bank $bank;
    private $name = 'bank';

    public function __construct(BankService $bankService, Bank $bank)
    {
        $this->bankService = $bankService;
        $this->bank = $bank;
    }

    public function index(BankDataTable $dataTable)
    {
        $this->logView($this->name, 'List');
        return $dataTable->render('admin.members.bank.list', [
            'title' => 'Danh sách thông tin ngân hàng',
            'email' => $this->bankService->getEmail()
        ]);
    }

    public function create()
    {
        $this->logView($this->name, 'Create');
        return view('admin.members.bank.add', [
            'title' => 'Thêm thông tin ngân hàng',
            'user' => $this->bankService->getEmail()
        ]);
    }

    public function store(BankFormRequest $request)
    {
        $result = $this->bankService->create($request);
        if ($result) {
            return redirect('user/bank/list');
        }

        return redirect()->back()->withInput();
    }

    public function show(Bank $id)
    {
        $this->logShow($this->name, $id);
        return view('admin.members.bank.edit', [
            'title' => 'Chỉnh Sửa thông tin ngân hàng: ' . $id->name,
            'banks' => $id,
            'user' => $this->bankService->getEmail()
        ]);
    }

    public function update(Bank $id, BankFormRequest $request)
    {
        $result = $this->bankService->update($id, $request);
        if ($result) {
            return redirect('user/bank/list');
        }

        return redirect()->back()->withInput();
    }

    public function destroy(Bank $id): JsonResponse
    {
        return $this->deleteTrait($id);
    }

    // Xoá nhiều thông tin ngân hàng của user cùng lúc
    public function deleteMultiple(): JsonResponse
    {
        return $this->deleteMultipleTrait($this->bank, $this->name);
    }

}
