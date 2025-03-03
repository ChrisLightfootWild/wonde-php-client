<?php

declare(strict_types=1);

namespace Wonde\Resources\QueryParameters;

class Includes implements QueryParameterInterface
{
    private array $resources;

    public function __construct(
        string ...$resource,
    ) {
        $this->resources = $resource;
    }

    public function toQueryString(): array
    {
        return [
            'include' => implode(',', $this->resources),
        ];
    }
}
