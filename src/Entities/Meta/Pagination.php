<?php

declare(strict_types=1);

namespace Wonde\Entities\Meta;

class Pagination
{
    public function __construct(
        public ?string $next,
        public ?string $previous,
        public bool $more,
        public int $perPage,
        public int $currentPage,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            next: $data['next'] ?? null,
            previous: $data['previous'] ?? null,
            more: $data['more'] ?? false,
            perPage: (int) ($data['per_page'] ?? 0),
            currentPage: (int) ($data['current_page'] ?? 1),
        );
    }
}
