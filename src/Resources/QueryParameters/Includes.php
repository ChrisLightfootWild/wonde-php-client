<?php

declare(strict_types=1);

namespace Wonde\Resources\QueryParameters;

class Includes
{
    private array $resources;

    public function __construct(
        string ...$resource,
    ) {
        $this->resources = $resource;
    }

    public function __toString(): string
    {
        return implode(',', $this->resources);
    }
}
