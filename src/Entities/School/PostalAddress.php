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

    public static function fromData(array $data): self
    {
        return new self(
            $data['address_line_1'],
            $data['address_line_2'],
            $data['address_town'],
            $data['address_postcode'],
            new Country(
                $data['address_country']['code'],
                $data['address_country']['name'],
            ),
        );
    }
}
