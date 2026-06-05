<?php

namespace App\DTOs\Section;

use Illuminate\Http\UploadedFile;

class SectionData
{
    public function __construct(
        public readonly string $name,
        public readonly ?UploadedFile $image = null,
        public readonly ?bool $active = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'active' => $this->active,
        ], fn ($value) => $value !== null);
    }
}
