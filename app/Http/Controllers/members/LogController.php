<?php

namespace App\Http\Controllers\members;

use App\DataTables\members\LogActionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\members\Log\LogActionService;
use App\Traits\DeleteMultipleTrait;
use App\Traits\LogShowTrait;
use App\Traits\LogViewTrait;
use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    use DeleteMultipleTrait, LogViewTrait, LogShowTrait;

    private LogActionService $actionService;
    private Activity $activity;
    private $name = 'log';

    public function __construct(LogActionService $actionService, Activity $activity)
    {
        $this->actionService = $actionService;
        $this->activity = $activity;
    }

    public function indexAction(LogActionDataTable $dataTable)
    {
//        $this->logView($this->name, 'List');
        return $dataTable->render('admin.members.log.log_action', [
            'title' => 'Log Action Users',
            'logname' => $this->actionService->uniqueLogName(),
            'description' => $this->actionService->uniqueDescription(),
            'users' => $this->actionService->uniqueCauserId()
        ]);
    }

    public function detailAction(Activity $id): JsonResponse
    {
//        $this->logShow($this->name, $id);
        $info = $id->activityUser()->get();
        return response()->json(['log' => $id, 'user' => $info]);
    }

    public function deleteMultipleAction(): JsonResponse
    {
        return $this->deleteMultipleTrait($this->activity, $this->name);
    }
}
