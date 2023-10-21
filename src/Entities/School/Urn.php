<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class Urn
{
    public function __construct(
        public int $identifier,
    ) {
    }
}
