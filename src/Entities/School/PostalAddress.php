<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class PostalAddress
{
    public function __construct(
        public string $line1,
        public string $line2,
        public string $town,
        public string $postcode,
        public Country $country,
    ) {
    }
}
