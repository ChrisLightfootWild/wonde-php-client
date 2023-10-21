<?php

declare(strict_types=1);

namespace Wonde\Tests\Feature\Resources;

use Wonde\Entities\School\PhaseOfEducation;
use Wonde\Tests\Feature\TestCase;

class SchoolsTest extends TestCase
{
    /** @test */
    public function it_can_get_a_school()
    {
        $response = $this->httpFactory->createResponse()->withBody(
            $this->httpFactory->createStreamFromFile(
                $this->pathToFixturesFile('schools/A1930499544/get-response.json'),
            ),
        );

        $this->mockHttpClient->addResponse($response);

        $school = $this->client->schools->get('A1930499544');

        self::assertEquals('A1930499544', $school->id);
        self::assertEquals('Wonde Testing School', $school->name);
        self::assertEquals(10000, $school->establishmentNumber->identifier);
        self::assertEquals(10003, $school->urn->identifier);
        self::assertEquals(PhaseOfEducation::SECONDARY, $school->phaseOfEducation);
        self::assertEquals('10000', $school->laCode);
        self::assertEquals(new \DateTimeZone('Europe/London'), $school->timeZone);
    }
}
