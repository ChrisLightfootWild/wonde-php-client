<?php

declare(strict_types=1);

namespace Wonde\Tests\Feature;

use GuzzleHttp\Psr7\HttpFactory;
use Http\Mock\Client as MockHttpClient;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Wonde\Client;

class TestCase extends BaseTestCase
{
    protected Client $client;
    protected HttpFactory $httpFactory;
    protected MockHttpClient $mockHttpClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->httpFactory = new HttpFactory();
        $this->mockHttpClient = new MockHttpClient();

        $this->client = new Client(
            'test-token',
            httpAsyncClient: $this->mockHttpClient,
        );
    }
}
