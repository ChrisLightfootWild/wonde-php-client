<?php

declare(strict_types=1);

namespace Wonde\Resources\QueryParameters;

class UrlParameter implements QueryParameterInterface
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
