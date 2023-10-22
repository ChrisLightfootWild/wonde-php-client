<?php

declare(strict_types=1);

namespace Wonde\Entities\School\RequestAccess;

class Requested
{
    public function __construct(
        public bool $success,
        public string $state,
        public string $message,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            $data['success'],
            $data['state'],
            $data['message'],
        );
    }
}
