<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Section\SectionFilterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Section\StoreSectionRequest;
use App\Http\Requests\Admin\Section\UpdateSectionRequest;
use App\Models\Section;
use App\Services\Section\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __construct(
        private readonly SectionService $sectionService
    ) {}

    public function index(Request $request)
    {
        $filter = SectionFilterData::fromRequest($request);

        return view('admin.sections.index', [
            'sections' => $this->sectionService->list($filter),
            'stats' => $this->sectionService->stats(),
            'filter' => $filter,
        ]);
    }

    public function store(StoreSectionRequest $request)
    {
        $this->sectionService->create($request->toDto());

        return back()->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function update(UpdateSectionRequest $request, Section $section)
    {
        $this->sectionService->update($section, $request->toDto());

        return back()->with('success', 'تم تحديث القسم بنجاح');
    }

    public function toggle(Section $section)
    {
        $this->sectionService->toggle($section);

        return back()->with('success', 'تم تحديث حالة القسم');
    }

    public function destroy(Section $section)
    {
        try {
            $this->sectionService->delete($section);

            return back()->with('success', 'تم حذف القسم بنجاح');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
