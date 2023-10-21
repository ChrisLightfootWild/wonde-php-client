<?php

declare(strict_types=1);

namespace Wonde\Tests\Feature\Resources;

use Http\Message\RequestMatcher;
use Psr\Http\Message\RequestInterface;
use Wonde\Tests\Feature\TestCase;

class SchoolsTest extends TestCase
{
    /** @test */
    public function it_can_get_a_school()
    {
        $response = $this->httpFactory->createResponse()->withBody(
            $this->httpFactory->createStreamFromFile(
                __DIR__ . '/../../Fixtures/v1.0/schools/A1930499544/get-response.json',
            ),
        );

        $this->mockHttpClient->on(new class() implements RequestMatcher {
            public function matches(RequestInterface $request): bool
            {
                return match ($request->getUri()->getPath()) {
                    'v1.0/schools/A1930499544' => true,
                    default => false,
                };
            }
        }, $response);

        $response = $this->client->schools->getRaw('A1930499544');
        self::assertEquals(200, $response->getStatusCode());

        $school = $this->client->schools->get('A1930499544');
        self::assertEquals('Wonde Testing School', $school->name);
    }
}
