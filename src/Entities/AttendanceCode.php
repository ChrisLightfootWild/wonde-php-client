<?php

declare(strict_types=1);

namespace Wonde\Entities;

class AttendanceCode
{
    public function __construct(
        public readonly string $id,
        public readonly string $code,
        public readonly string $description,
        public readonly string $type,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            $data['id'],
            $data['code'],
            $data['description'],
            $data['type'],
        );
    }
}
