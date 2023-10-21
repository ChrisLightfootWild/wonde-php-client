<?php

declare(strict_types=1);

namespace Wonde\Entities;

use DateTimeZone;
use Wonde\Entities\School\Country;
use Wonde\Entities\School\EstablishmentNumber;
use Wonde\Entities\School\Extended;
use Wonde\Entities\School\PhaseOfEducation;
use Wonde\Entities\School\PostalAddress;
use Wonde\Entities\School\Region;
use Wonde\Entities\School\Urn;

class School
{
    public function __construct(
        public string $id,
        public string $name,
        public EstablishmentNumber $establishmentNumber,
        public Urn $urn,
        public PhaseOfEducation $phaseOfEducation,
        public string $laCode,
        public ?DateTimeZone $timeZone = null,
        public ?string $mis = null,
        public ?PostalAddress $address = null,
        public ?Extended $extended = null,
        public ?Region $region = null,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            establishmentNumber: new EstablishmentNumber($data['establishment_number']),
            urn: new Urn($data['urn']),
            phaseOfEducation: PhaseOfEducation::from($data['phase_of_education']),
            laCode: $data['la_code'],
            timeZone: ($data['timezone'] ?? null) ? new DateTimeZone($data['timezone']) : null,
            mis: $data['mis'] ?? null,
            address: PostalAddress::fromData($data['address']),
            extended: Extended::fromData($data['extended']),
            region: Region::fromData($data['region']),
        );
    }
}
