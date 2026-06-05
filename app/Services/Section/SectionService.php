<?php

namespace App\Services\Section;

use App\Contracts\Repositories\SectionRepositoryInterface;
use App\DTOs\Section\SectionData;
use App\DTOs\Section\SectionFilterData;
use App\Models\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class SectionService
{
    public function __construct(
        private readonly SectionRepositoryInterface $repository
    ) {}

    public function list(SectionFilterData $filter): LengthAwarePaginator
    {
        return $this->repository->paginate($filter);
    }

    public function stats(): array
    {
        return $this->repository->getStats();
    }

    public function create(SectionData $data): Section
    {
        $section = $this->repository->create($data);

        if ($data->image) {
            $section->update([
                'image' => $data->image->store('sections', 'public'),
            ]);
        }

        return $section->fresh();
    }

    public function update(Section $section, SectionData $data): Section
    {
        if ($data->image) {
            $this->deleteImage($section);
            $section->image = $data->image->store('sections', 'public');
            $section->save();
        }

        return $this->repository->update($section, $data);
    }

    public function toggle(Section $section): Section
    {
        return $this->repository->toggle($section);
    }

    public function delete(Section $section): void
    {
        if ($section->categories()->exists()) {
            throw new \RuntimeException('لا يمكن حذف قسم مرتبط بفئات. انقل الفئات أولاً.');
        }

        $this->deleteImage($section);
        $this->repository->delete($section);
    }

    private function deleteImage(Section $section): void
    {
        if ($section->image && Storage::disk('public')->exists($section->image)) {
            Storage::disk('public')->delete($section->image);
        }
    }
}
