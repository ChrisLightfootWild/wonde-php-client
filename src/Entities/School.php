<?php

declare(strict_types=1);

namespace Wonde\Entities;

use DateTimeZone;
use Wonde\Entities\School\EstablishmentNumber;
use Wonde\Entities\School\Extended;
use Wonde\Entities\School\PhaseOfEducation;
use Wonde\Entities\School\PostalAddress;
use Wonde\Entities\School\Region;

class School
{
    public function __construct(
        public string $id,
        public string $name,
        public EstablishmentNumber $establishmentNumber,
        public string $urn,
        public PhaseOfEducation $phaseOfEducation,
        public string $laCode,
        public ?DateTimeZone $timeZone = null,
        public ?string $mis = null,
        public ?PostalAddress $address = null,
        public ?Extended $extended = null,
        public ?Region $region = null,
    ) {
    }
}
