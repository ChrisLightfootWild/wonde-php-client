<?php

declare(strict_types=1);

namespace Wonde;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpAsyncClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\Authentication\Bearer;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Wonde\Resources\AttendanceCodes;
use Wonde\Resources\Meta;
use Wonde\Resources\Schools;

class Client
{
    public const VERSION = '4.x';

    public AttendanceCodes $attendanceCodes;
    public Meta $meta;
    public Schools $schools;

    public readonly ClientOptions $options;
    public readonly HttpAsyncClient $httpAsyncClient;
    public readonly LoggerInterface $logger;
    public readonly RequestFactoryInterface $requestFactory;
    public readonly StreamFactoryInterface $streamFactory;
    public readonly UriFactoryInterface $uriFactory;

    private readonly ClientToken $token;

    public function __construct(
        ClientToken|string $token,
        ?ClientOptions $options = null,
        LoggerInterface $logger = null,
        ?HttpAsyncClient $httpAsyncClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?UriFactoryInterface $uriFactory = null,
    ) {
        $this->token = $token instanceof ClientToken ? $token : new ClientToken($token);
        $this->options = $options ?? new ClientOptions();
        $this->logger = $logger ?? new NullLogger();

        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->uriFactory = $uriFactory ?? Psr17FactoryDiscovery::findUriFactory();

        $this->buildClient(
            $httpAsyncClient ?? Psr18ClientDiscovery::find(),
        );

        $this->buildServices();
    }

    protected function buildClient(HttpAsyncClient $httpClient): void
    {
        $this->httpAsyncClient = new PluginClient($httpClient, [
            new AuthenticationPlugin(new Bearer($this->token)),
            new DecoderPlugin(),
            new HeaderSetPlugin([
                'User-Agent' => 'wonde-php-client-' . static::VERSION,
            ]),
        ]);
    }

    protected function buildServices(): void
    {
        $this->attendanceCodes = new AttendanceCodes($this);
        $this->meta = new Meta($this);
        $this->schools = new Schools($this);
    }
}
