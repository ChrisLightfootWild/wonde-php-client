<?php

declare(strict_types=1);

namespace Wonde\Resources\QueryParameters;

use Wonde\Contracts\Requests\QueryParameter;

class Pagination implements QueryParameter
{
    public function __construct(
        public readonly int $perPage,
    ) {
    }

    public function toQueryString(): array
    {
        return [
            'per_page' => $this->perPage,
        ];
    }
}
