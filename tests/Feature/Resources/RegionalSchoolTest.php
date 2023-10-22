<?php

declare(strict_types=1);

namespace Wonde\Tests\Feature\Resources;

use Http\Message\RequestMatcher;
use Psr\Http\Message\RequestInterface;
use Wonde\Entities\School;
use Wonde\Tests\Feature\TestCase;

class RegionalSchoolTest extends TestCase
{
    /** @test */
    public function it_uses_a_regional_school_domain()
    {
        $school = new School(
            'A-TEST-SCHOOL',
            'test-school',
            new School\EstablishmentNumber('98765'),
            new School\Urn(123),
            School\PhaseOfEducation::NOT_APPLICABLE,
            '456',
            region: new School\Region(
                'AUS',
                'test.wonde.local',
                'https://test.wonde.local/v1.0/schools/A-TEST-SCHOOL',
                new School\Identifiers(
                    '456',
                    new School\EstablishmentNumber('98765'),
                    new School\Urn(123),
                ),
            ),
        );

        $this->mockHttpClient->on(new class() implements RequestMatcher {
            public function matches(RequestInterface $request): bool
            {
                return (
                    $request->getUri()->getHost() === 'test.wonde.local'
                    && (string) $request->getUri() === 'https://test.wonde.local/v1.0/schools/A-TEST-SCHOOL/counts'
                );
            }
        }, $this->httpFactory->createResponse(418));

        $response = $this->client->school($school)->counts->getRaw();

        self::assertEquals(418, $response->getStatusCode());
    }
}
