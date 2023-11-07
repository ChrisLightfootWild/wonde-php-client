<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Wonde\Util\JSON;
use function json_encode;

class ApiResource extends Resource
{
    public function get(string $endpoint, array $parameters = []): array
    {
        return JSON::decodeFromResponse($this->getRaw($endpoint, $parameters));
    }

    public function post(string $endpoint, array $payload): array
    {
        return JSON::decodeFromResponse($this->postRaw($endpoint, $this->client->streamFactory->createStream(
            json_encode($payload),
        )));
    }

    public function delete(string $endpoint): ?array
    {
        return JSON::decodeFromResponse($this->deleteRaw($endpoint));
    }
}
