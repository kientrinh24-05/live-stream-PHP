<?php

namespace App\Http\Controllers\apps;

use App\DataTables\apps\PromoteDataTable;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\apps\Promote\PromoteFormRequest;
use App\Http\Requests\apps\Promote\UpdatePromoteFormRequest;
use App\Http\Services\apps\Promote\PromoteService;
use App\Models\apps\Promote;
use App\Traits\LogViewTrait;
use App\Traits\StatusActiveTrait;
use App\Traits\StatusBlockTrait;
use Illuminate\Http\JsonResponse;

class PromoteController extends Controller
{
    use LogViewTrait, StatusActiveTrait, StatusBlockTrait;

    private AdminController $adminController;
    private PromoteService $promoteService;
    private Promote $promote;
    private $name = 'promote';

    public function __construct(PromoteService $promoteService, Promote $promote, AdminController $adminController)
    {
        $this->adminController = $adminController;
        $this->promoteService = $promoteService;
        $this->promote = $promote;
    }

    public function index(PromoteDataTable $dataTable)
    {
        $this->logView($this->name, 'List');
        return $dataTable->render('admin.apps.promote.list', [
            'title' => 'Đề xuất ứng dụng',
            'applications' => $this->adminController->getApp()
        ]);
    }

    public function create()
    {
        $this->logView($this->name, 'Create');
        return view('admin.apps.promote.add', [
            'title' => 'Thêm đề xuất ứng dụng mới'
        ]);
    }

    public function store(PromoteFormRequest $request)
    {
        $result = $this->promoteService->create($request);
        if ($result) {
            return redirect('app/promote/list');
        }

        return redirect()->back()->withInput();
    }

    public function show(Promote $id)
    {
//        $this->logShow($this->name, $id);
        return view('admin.apps.promote.edit', [
            'title' => 'Chỉnh sửa đề xuất ứng dụng',
            'promote' => $id,
        ]);
    }

    public function update(Promote $id, UpdatePromoteFormRequest $request)
    {
        $result = $this->promoteService->update($id, $request);
        if ($result) {
            return redirect('app/promote/list');
        }

        return redirect()->back()->withInput();
    }

    public function destroy(Promote $id): JsonResponse
    {
        return $this->deleteTrait($id);
    }

    // Xoá nhiều bản ghi cùng lúc
    public function deleteMultiple(): JsonResponse
    {
        return $this->deleteMultipleTrait($this->user, $this->name, 'user_id', [
            'Member_info' => 'member_info_del',
            'New_Tutorials' => 'New_Tutorials_del',
            'banks' => 'banks_del',
            'apply_jobs' => 'apply_jobs_del',
            'comments' => 'comments_del',
            'role_user' => 'role_user_del'
        ], 'users_del', 'causer_id', 'activity_log', 'activity_log_del');
    }

    // Kích hoạt status
    public function active(Promote $id): JsonResponse
    {
        return $this->statusActiveTrait($id);
    }

    // Vô hiệu hoá status
    public function deactive(Promote $id): JsonResponse
    {
        return $this->statusBlockTrait($id);
    }
}
