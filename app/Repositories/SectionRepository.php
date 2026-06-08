<?php

namespace App\Repositories;

use App\Contracts\Repositories\SectionRepositoryInterface;
use App\DTOs\Section\SectionData;
use App\DTOs\Section\SectionFilterData;
use App\Models\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SectionRepository implements SectionRepositoryInterface
{
    public function paginate(SectionFilterData $filter): LengthAwarePaginator
    {
        $query = Section::query();

        if ($filter->search) {
            $query->where('name', 'like', '%' . $filter->search . '%');
        }

        if ($filter->status !== null && $filter->status !== '') {
            $query->where('active', $filter->status === 'active' ? 1 : 0);
        }

        return $query
            ->orderBy($filter->sortBy, $filter->sortOrder)
            ->paginate($filter->perPage)
            ->withQueryString();
    }

    public function getStats(): array
    {
        $total = Section::count();

        return [
            'total' => $total,
            'active' => Section::where('active', 1)->count(),
            'inactive' => Section::where('active', 0)->count(),
        ];
    }

    public function create(SectionData $data): Section
    {
        return Section::create([
            ...$data->toArray(),
            'active' => $data->active ?? true,
        ]);
    }

    public function update(Section $section, SectionData $data): Section
    {
        $section->fill($data->toArray());
        $section->save();

        return $section->fresh();
    }

    public function toggle(Section $section): Section
    {
        $section->update(['active' => !$section->active]);

        return $section->fresh();
    }

    public function delete(Section $section): bool
    {
        return (bool) $section->delete();
    }
}
