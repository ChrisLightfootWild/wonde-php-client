<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Wonde\Client;

abstract class Resource
{
    public function __construct(
        protected readonly Client $client,
    ) {
    }

    public function deleteRaw(string $path = ''): ResponseInterface
    {
        return $this->requestRaw('DELETE', $path);
    }

    public function getRaw(string $path = '', array $parameters = []): ResponseInterface
    {
        return $this->requestRaw('GET', $path, $parameters);
    }

    public function postRaw(string $path, StreamInterface $stream): ResponseInterface
    {
        return $this->requestRaw('POST', $path, stream: $stream);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return $this->client->uriFactory->createUri(
            $this->client->options->environment->rootDomain(),
        )->withPath("{$version}/{$path}");
    }

    protected function decodeJsonBody(ResponseInterface $response): array
    {
        $json = json_decode((string) $response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $jsonErrorMessage = json_last_error_msg();

            $this->client->logger->error('Decoding JSON body from response failed', [
                'json-error-message' => $jsonErrorMessage,
            ]);

            throw new \ValueError($jsonErrorMessage);
        }

        return $json;
    }

    protected function requestRaw(
        string $method,
        string $path = '',
        array $parameters = [],
        StreamInterface $stream = null,
    ): ResponseInterface
    {
        $uri = $this->buildUri($path);

        if ($parameters) {
            $uri = $uri->withQuery(http_build_query($parameters));
        }

        $request = $this->client->requestFactory->createRequest($method, $uri);

        if ($stream) {
            $request = $request->withBody($stream);
        }

        return $this->client->httpAsyncClient->sendAsyncRequest($request)->wait();
    }
}
