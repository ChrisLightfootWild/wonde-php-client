<?php

declare(strict_types=1);

namespace Wonde;

class ClientOptions
{
    public function __construct(
        public Environment $environment = Environment::LIVE,
        public ?int $maximumItemsInAutoPaginatingCollection = null,
        public bool $allowTelemetry = true,
    ) {
    }
}
