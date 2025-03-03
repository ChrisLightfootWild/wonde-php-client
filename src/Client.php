<?php

declare(strict_types=1);

namespace Wonde;

use Composer\InstalledVersions;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ContentTypePlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpAsyncClient as HttpAsyncClientInterface;
use Http\Discovery\HttpAsyncClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\Bearer;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Wonde\Entities\School;
use Wonde\Resources\ApiResource;
use Wonde\Resources\AttendanceCodes;
use Wonde\Resources\Meta;
use Wonde\Resources\School as SchoolResource;
use Wonde\Resources\Schools;

class Client
{
    public const VERSION = '4.x';

    public readonly ApiResource $api;
    public readonly AttendanceCodes $attendanceCodes;
    public readonly Meta $meta;
    public readonly Schools $schools;

    public readonly ClientOptions $options;
    public readonly HttpAsyncClientInterface $httpAsyncClient;
    public readonly LoggerInterface $logger;
    public readonly RequestFactoryInterface $requestFactory;
    public readonly StreamFactoryInterface $streamFactory;
    public readonly UriFactoryInterface $uriFactory;

    private readonly ClientToken $token;

    public function __construct(
        ClientToken|string $token,
        ?ClientOptions $options = null,
        LoggerInterface $logger = null,
        ?HttpAsyncClientInterface $httpAsyncClient = null,
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
            $httpAsyncClient ?? HttpAsyncClientDiscovery::find(),
        );

        $this->buildServices();
    }

    public function school(School|string $school): SchoolResource
    {
        $school = $school instanceof School ? $school : $this->schools->get($school);

        return new SchoolResource($this, $school);
    }

    protected function buildClient(HttpAsyncClientInterface $httpClient): void
    {
        $this->httpAsyncClient = new PluginClient($httpClient, [
            new AuthenticationPlugin(new Bearer($this->token)),
            new ContentTypePlugin(),
            new DecoderPlugin(),
            new HeaderAppendPlugin([
                'User-Agent' => $this->userAgent(),
            ]),
        ]);
    }

    protected function buildServices(): void
    {
        $this->api = new ApiResource($this);
        $this->attendanceCodes = new AttendanceCodes($this);
        $this->meta = new Meta($this);
        $this->schools = new Schools($this);
    }

    private function userAgent(): string
    {
        $components = ['Wonde'];

        $version = class_exists(InstalledVersions::class)
            ? InstalledVersions::getPrettyVersion('wondeltd/php-client')
            : self::VERSION;

        $components[] = sprintf('(wondeltd/php-client; %s)', $version);

        if ($this->options->allowTelemetry) {
            $components[] = sprintf('(%s; PHP/%s)', PHP_OS_FAMILY, PHP_VERSION);
        }

        return implode(' ', $components);
    }
}
