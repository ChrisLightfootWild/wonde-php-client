<?php

declare(strict_types=1);

namespace Wonde\Tests\Feature\Resources;

use Http\Message\RequestMatcher;
use Psr\Http\Message\RequestInterface;
use Wonde\Resources\Requests\RequestAccess\Contact;
use Wonde\Resources\Requests\SchoolAccessRequest;
use Wonde\Tests\Feature\TestCase;

class SchoolsTest extends TestCase
{
    /** @test */
    public function it_can_get_a_school()
    {
        $this->mockHttpClient->on(new class() implements RequestMatcher {
            public function matches(RequestInterface $request): bool
            {
                return $request->getUri()->getPath() === 'v1.0/schools/A1930499544';
            }
        }, fn () => $this->httpFactory->createResponse()->withBody(
            $this->httpFactory->createStreamFromFile(
                __DIR__ . '/../../Fixtures/v1.0/schools/A1930499544/get-response.json',
            ),
        ));

        $response = $this->client->schools->getRaw('A1930499544');
        self::assertEquals(200, $response->getStatusCode());

        $school = $this->client->schools->get('A1930499544');
        self::assertEquals('Wonde Testing School', $school->name);
    }

    /** @test */
    public function it_can_request_access_to_a_school()
    {
        $this->mockHttpClient->on(new class() implements RequestMatcher {
            public function matches(RequestInterface $request): bool
            {
                return (
                    $request->getMethod() === 'POST'
                    && $request->getUri()->getPath() === 'v1.0/schools/TEST-SCHOOL/request-access'
                    && (string) $request->getBody() === json_encode([
                        'contacts' => [
                            [
                                'first_name' => 'hello',
                                'last_name' => 'world',
                                'phone_number' => null,
                                'email_address' => null,
                                'notes' => null,
                            ],
                            [
                                'first_name' => 'foo',
                                'last_name' => 'bar',
                                'phone_number' => null,
                                'email_address' => 'test@wonde.local',
                                'notes' => null,
                            ],
                        ],
                    ])
                );
            }
        }, function () {
            $json = json_encode([
                'success' => true,
                'state' => 'pending',
                'message' => 'Access request successfully received',
            ]);

            return $this->httpFactory->createResponse()->withBody(
                $this->httpFactory->createStream($json),
            );
        });

        $schoolAccessRequest = new SchoolAccessRequest(
            new Contact('hello', 'world'),
            new Contact('foo', 'bar', emailAddress: 'test@wonde.local'),
        );

        $requested = $this->client->schools->requestAccess('TEST-SCHOOL', $schoolAccessRequest);
        self::assertTrue($requested->success);
        self::assertEquals('pending', $requested->state);
        self::assertEquals('Access request successfully received', $requested->message);
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
