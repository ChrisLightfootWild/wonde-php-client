<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class EstablishmentNumber
{
    public readonly string $identifier;

    public function __construct(
        string|int $identifier,
    ) {
        $this->identifier = (string) $identifier;
    }
}
