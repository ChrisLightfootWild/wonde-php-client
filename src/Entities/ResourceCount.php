<?php

declare(strict_types=1);

namespace Wonde\Entities;

class ResourceCount
{
    public function __construct(
        public readonly string $resource,
        public readonly int $count,
    ) {
    }
}
