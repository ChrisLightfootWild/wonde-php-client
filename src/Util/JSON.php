<?php

declare(strict_types=1);

namespace Wonde\Util;

use Psr\Http\Message\ResponseInterface;
use function json_decode;
use function json_last_error;
use function json_last_error_msg;

final class JSON
{
    public static function decodeFromResponse(ResponseInterface $response): ?array
    {
        if (empty($body = (string) $response->getBody())) {
            return null;
        }

        $json = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \ValueError(json_last_error_msg());
        }

        return $json;
    }
}
