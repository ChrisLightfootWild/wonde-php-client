<?php

declare(strict_types=1);

namespace Wonde\Util;

use Psr\Http\Message\ResponseInterface;

final class JSON
{
    public static function decodeFromResponse(ResponseInterface $response): array
    {
        $json = json_decode((string) $response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \ValueError(json_last_error_msg());
        }

        return $json;
    }
}
