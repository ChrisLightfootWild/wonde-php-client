<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class Country
{
    public function __construct(
        public string $code,
        public string $name,
    ) {
    }
}
