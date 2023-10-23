<?php

declare(strict_types=1);

namespace Wonde\Resources\QueryParameters;

use Wonde\Contracts\Requests\QueryParameter;

class Pagination implements QueryParameter
{
    public function __construct(
        public readonly ?int $perPage = null,
        public readonly bool $useCursor = false,
    ) {
    }

    public function toQueryString(): array
    {
        return array_filter([
            'per_page' => $this->perPage,
            'cursor' => $this->useCursor,
        ]);
    }
}
