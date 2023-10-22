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

    /** @test */
    public function it_can_revoke_access_to_a_school()
    {
        $this->mockHttpClient->on(new class() implements RequestMatcher {
            public function matches(RequestInterface $request): bool
            {
                return (
                    $request->getMethod() === 'DELETE'
                    && $request->getUri()->getPath() === 'v1.0/schools/TEST-DELETION/revoke-access'
                );
            }
        }, function () {
            $json = json_encode([
                'success' => true,
                'state' => 'revoked',
                'message' => 'Access revoked',
            ]);

            return $this->httpFactory->createResponse()->withBody(
                $this->httpFactory->createStream($json),
            );
        });

        $revoked = $this->client->schools->revokeAccess('TEST-DELETION');
        self::assertTrue($revoked->success);
        self::assertEquals('revoked', $revoked->state);
        self::assertEquals('Access revoked', $revoked->message);
    }
}
