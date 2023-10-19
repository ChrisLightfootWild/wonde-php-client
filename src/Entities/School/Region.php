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
}
