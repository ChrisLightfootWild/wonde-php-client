<?php

declare(strict_types=1);

namespace Wonde\Tests\Feature;

use Http\Message\RequestMatcher;
use Psr\Http\Message\RequestInterface;

class ClientTest extends TestCase
{
    /** @test */
    public function it_sets_the_useragent()
    {
        $this->mockHttpClient->on(new class($this) implements RequestMatcher {
            public function __construct(
                private TestCase $testCase,
            ) {
            }

            public function matches(RequestInterface $request): bool
            {
                $userAgent = $request->getHeaderLine('User-Agent');
                $this->testCase::assertStringContainsString('wondeltd/php-client; 4.x-dev', $userAgent);
                $this->testCase::assertStringContainsString(PHP_OS_FAMILY, $userAgent);
                $this->testCase::assertStringContainsString('PHP/' . PHP_VERSION, $userAgent);

                return false;
            }
        }, fn () => $this->httpFactory->createResponse());

        $this->client->httpAsyncClient->sendAsyncRequest(
            $this->httpFactory->createRequest('GET', 'testing'),
        );
    }
}
