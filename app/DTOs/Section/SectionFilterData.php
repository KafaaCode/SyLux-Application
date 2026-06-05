<?php

namespace App\DTOs\Section;

use Illuminate\Http\Request;

class SectionFilterData
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $status = null,
        public readonly string $sortBy = 'created_at',
        public readonly string $sortOrder = 'desc',
        public readonly int $perPage = 15,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            search: $request->filled('search') ? $request->string('search')->toString() : null,
            status: $request->filled('status') ? $request->string('status')->toString() : null,
            sortBy: in_array($request->get('sort_by'), ['name', 'created_at'], true)
                ? $request->get('sort_by')
                : 'created_at',
            sortOrder: $request->get('sort_order') === 'asc' ? 'asc' : 'desc',
            perPage: max(5, min(50, (int) $request->get('per_page', 15))),
        );
    }
}
