<?php

declare(strict_types=1);

namespace Wonde\Resources\QueryParameters;

use Wonde\Contracts\Requests\QueryParameter;

class Generic implements QueryParameter
{
    public function __construct(
        public readonly string $key,
        public readonly string $value,
    ) {
    }

    public function toQueryString(): array
    {
        return [
            $this->key => $this->value,
        ];
    }
}
