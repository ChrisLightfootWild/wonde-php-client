<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class Identifiers
{
    public function __construct(
        public readonly string $laCode,
        public readonly EstablishmentNumber $establishmentNumber,
        public readonly Urn $urn,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            laCode: $data['la_code'],
            establishmentNumber: new EstablishmentNumber($data['establishment_number']),
            urn: new Urn($data['urn']),
        );
    }
}
