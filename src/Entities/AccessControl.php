<?php

declare(strict_types=1);

namespace Wonde\Entities;

class AccessControl
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            $data['id'],
            $data['type'],
        );
    }
}
