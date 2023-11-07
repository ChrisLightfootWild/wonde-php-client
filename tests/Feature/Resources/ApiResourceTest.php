<?php

declare(strict_types=1);

namespace Feature\Resources;

use Http\Message\RequestMatcher;
use Psr\Http\Message\RequestInterface;
use Wonde\Tests\Feature\TestCase;

class ApiResourceTest extends TestCase
{
    /** @test */
    public function it_can_get_an_endpoint()
    {
        $mockResponse = $this->httpFactory->createResponse();
        $mockResponse = $mockResponse->withBody($this->httpFactory->createStream('{"data":[],"meta":[]}'));

        $this->mockHttpClient->on(new class($this) implements RequestMatcher {
            public function __construct(
                private readonly TestCase $testCase,
            ) {
            }

            public function matches(RequestInterface $request): bool
            {
                $this->testCase::assertEquals('GET', $request->getMethod());
                $this->testCase::assertEquals('v1.0/examples', $request->getUri()->getPath());
                // URL encoding takes place here, so we must account for it.
                $this->testCase::assertEquals('a=1&b=2&include=foo%2Cbar', $request->getUri()->getQuery());

                return true;
            }
        }, $mockResponse);

        $data = $this->client->api->get('examples', [
            'a' => 1,
            'b' => 2,
            'include' => 'foo,bar',
        ]);

        self::assertEquals([
            'data' => [],
            'meta' => [],
        ], $data);
    }

    /** @test */
    public function it_can_post_an_endpoint()
    {
        $mockResponse = $this->httpFactory->createResponse();
        $mockResponse = $mockResponse->withBody($this->httpFactory->createStream('{"id":"test-id"}'));

        $this->mockHttpClient->on(new class($this) implements RequestMatcher {
            public function __construct(
                private readonly TestCase $testCase,
            ) {
            }

            public function matches(RequestInterface $request): bool
            {
                $this->testCase::assertEquals('POST', $request->getMethod());
                $this->testCase::assertEquals('v1.0/examples', $request->getUri()->getPath());
                $this->testCase::assertEquals('{"payload":"..."}', (string) $request->getBody());

                return true;
            }
        }, $mockResponse);

        $data = $this->client->api->post('examples', [
            'payload' => '...',
        ]);

        self::assertEquals([
            'id' => 'test-id',
        ], $data);
    }
}
