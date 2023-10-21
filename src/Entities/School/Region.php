<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class Region
{
    public function __construct(
        public readonly string $code,
        public readonly string $domain,
        public readonly string $schoolUrl,
        public readonly Identifiers $identifiers,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            code: $data['code'],
            domain: $data['domain'],
            schoolUrl: $data['school_url'],
            identifiers: Identifiers::fromData($data['identifiers']),
        );
    }
}
