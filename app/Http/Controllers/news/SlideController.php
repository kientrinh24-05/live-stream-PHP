<?php

namespace App\Http\Controllers\news;

use App\DataTables\news\SlideDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\news\Slide\SlideFormRequest;
use App\Http\Services\news\Slide\SlideService;
use App\Models\news\Slide;
use App\Traits\DeleteMultipleTrait;
use App\Traits\DeleteTrait;
use App\Traits\LogShowTrait;
use App\Traits\LogViewTrait;
use Illuminate\Http\JsonResponse;

class SlideController extends Controller
{
    use DeleteTrait, DeleteMultipleTrait, LogViewTrait, LogShowTrait;
    private SlideService $slideService;
    private Slide $slide;
    private $name = 'slide';

    public function __construct(SlideService $slideService, Slide $slide)
    {
        $this->slideService = $slideService;
        $this->slide = $slide;
    }

    public function index(SlideDataTable $dataTable)
    {
        $this->logView($this->name, 'List');
        return $dataTable->render('admin.news.slide.list', [
            'title' => 'Danh Sách Slider',
        ]);
    }

    public function create()
    {
        $this->logView($this->name, 'Create');
        return view('admin.news.slide.add', [
            'title' => 'Thêm Slider mới'
        ]);
    }

    public function store(SlideFormRequest $request)
    {
        $result = $this->slideService->create($request);
        if ($result) {
            return redirect('news/slide/list');
        }

        return redirect()->back()->withInput();
    }

    public function show(Slide $id)
    {
        $this->logShow($this->name, $id);
        return view('admin.news.slide.edit', [
            'title' => 'Chỉnh Sửa Slider',
            'slide' => $id
        ]);
    }

    public function update(SlideFormRequest $request, Slide $id)
    {
        $result = $this->slideService->update($request, $id);
        if ($result) {
            return redirect('news/slide/list');
        }

        return redirect()->back()->withInput();
    }

    public function destroy(Slide $id): JsonResponse
    {
       return $this->deleteTrait($id);
    }

    // Xoá nhiều bản ghi cùng lúc
    public function deleteMultiple(): JsonResponse
    {
        return $this->deleteMultipleTrait($this->slide, $this->name, 'slides_del');
    }
}
