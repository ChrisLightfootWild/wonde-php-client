<?php

declare(strict_types=1);

namespace Wonde;

use Wonde\Exceptions\InvalidTokenException;

class ClientToken
{
    /**
     * @throws InvalidTokenException
     */
    public function __construct(
        #[\SensitiveParameter]
        public readonly string $secret,
    )
    {
        if (empty($secret)) {
            throw new InvalidTokenException('Token string is required');
        }
    }

    public function __toString(): string
    {
        return $this->secret;
    }
}
