<?php

declare(strict_types=1);

namespace Unit\Resources;

use PHPUnit\Framework\TestCase;
use Wonde\Entities\School;
use Wonde\Entities\School\Country;
use Wonde\Entities\School\EstablishmentNumber;
use Wonde\Entities\School\Extended;
use Wonde\Entities\School\Identifiers;
use Wonde\Entities\School\PhaseOfEducation;
use Wonde\Entities\School\PostalAddress;
use Wonde\Entities\School\Region;
use Wonde\Entities\School\Urn;

class SchoolsTest extends TestCase
{
    /** @test */
    public function it_hydrates_from_valid_data()
    {
        $json = json_decode(
            file_get_contents(__DIR__ . '/../../Fixtures/v1.0/schools/A1930499544/get-response.json'),
            true,
        );

        $school = School::fromData($json['data']);

        self::assertEquals('A1930499544', $school->id);
        self::assertEquals('Wonde Testing School', $school->name);
        self::assertEquals(10000, $school->establishmentNumber->identifier);
        self::assertEquals(10003, $school->urn->identifier);
        self::assertEquals(PhaseOfEducation::SECONDARY, $school->phaseOfEducation);
        self::assertEquals('10000', $school->laCode);
        self::assertEquals(new \DateTimeZone('Europe/London'), $school->timeZone);
        self::assertEquals('SIMS', $school->mis);

        self::assertEquals(new PostalAddress(
            'Address Line 1',
            'Address Line 2',
            'Address Town',
            'CB8 7SG',
            new Country('GBR', 'England'),
        ), $school->address);

        self::assertEquals(new Extended(
            allowsWriteback: true,
            hasTimetables: true,
            hasLessonAttendance: true,
            auditApprovedAt: new \DateTimeImmutable('2022-01-28 15:45:10'),
        ), $school->extended);

        self::assertEquals(new Region(
            'GBR',
            'api.wonde.com',
            'https://api.wonde.com/v1.0/schools/A1930499544',
            new Identifiers(
                '10000',
                new EstablishmentNumber('10000'),
                new Urn(10003),
            ),
        ), $school->region);
    }
}
