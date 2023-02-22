<?php

namespace App\Http\Controllers\data;

use App\DataTables\data\ApplyJobDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\data\ApplyJob\ApplyJobFormRequest;
use App\Http\Services\data\Apply_Job\ApplyJobService;
use App\Models\data\Apply_Job;
use App\Traits\DeleteMultipleTrait;
use App\Traits\DeleteTrait;
use App\Traits\LogShowTrait;
use App\Traits\LogViewTrait;
use App\Traits\StatusActiveTrait;
use App\Traits\StatusBlockTrait;
use Illuminate\Http\JsonResponse;

class ApplyJobController extends Controller
{
    use DeleteTrait, DeleteMultipleTrait, StatusActiveTrait, StatusBlockTrait, LogShowTrait, LogViewTrait;

    private ApplyJobService $applyJobService;
    private Apply_Job $apply_Job;
    private $name = 'apply_job';

    public function __construct(ApplyJobService $applyJobService, Apply_Job $apply_Job)
    {
        $this->applyJobService = $applyJobService;
        $this->apply_Job = $apply_Job;
    }

    public function index(ApplyJobDataTable $dataTable)
    {
        return $dataTable->render('admin.data.apply_job.list', [
            'title' => 'Danh sách đăng ký live stream',
            'users' => $this->applyJobService->filterUser(),
            'apps' => $this->applyJobService->filterApplication()
        ]);
    }

    public function create()
    {
        return view('admin.data.apply_job.add', [
            'title' => 'Thêm đăng ký mới',
            'email' => $this->applyJobService->getEmail(),
            'agency' => $this->applyJobService->getAgency(),
        ]);
    }

    public function store(ApplyJobFormRequest $request)
    {
        $result = $this->applyJobService->create($request);
        if ($result) {
            return redirect('data/job/list');
        }

        return redirect()->back()->withInput();
    }

    public function show(Apply_Job $id)
    {
        return view('admin.data.apply_job.edit', [
            'title' => 'Chỉnh Sửa Apply Job: ' . $id->name,
            'jobs' => $id,
            'user' => $this->applyJobService->getUser($id->user_id),
            'email' => $this->applyJobService->getEmail(),
            'agency' => $this->applyJobService->getAgency(),
        ]);
    }


    public function update(Apply_Job $id, ApplyJobFormRequest $request)
    {
        $result = $this->applyJobService->update($request, $id);
        if ($result) {
            return redirect('data/job/list');
        }

        return redirect()->back()->withInput();
    }

    public function destroy(Apply_Job $id): JsonResponse
    {
        return $this->deleteTrait($id);
    }

    // Xoá nhiều bản ghi cùng lúc
    public function deleteMultiple(): JsonResponse
    {
        return $this->deleteMultipleTrait($this->apply_Job, $this->name);
    }

    // Lấy info user theo email
    public function getUser(): JsonResponse
    {
        $user = $this->applyJobService->getUser(request('id'));
        return response()->json($user);
    }
}
