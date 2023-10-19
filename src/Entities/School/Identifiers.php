<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class Identifiers
{
    public function __construct(
        public readonly string $laCode,
        public readonly EstablishmentNumber $establishmentNumber,
        public readonly string $urn,
    ) {
    }
}
