<?php

namespace App\Contracts\Repositories;

use App\DTOs\Section\SectionData;
use App\DTOs\Section\SectionFilterData;
use App\Models\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SectionRepositoryInterface
{
    public function paginate(SectionFilterData $filter): LengthAwarePaginator;

    public function getStats(): array;

    public function create(SectionData $data): Section;

    public function update(Section $section, SectionData $data): Section;

    public function toggle(Section $section): Section;

    public function delete(Section $section): bool;
}
