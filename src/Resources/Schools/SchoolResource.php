<?php

declare(strict_types=1);

namespace Wonde\Resources\Schools;

use Psr\Http\Message\UriInterface;
use Wonde\Client;
use Wonde\Entities\School;
use Wonde\Resources\Resource;

abstract class SchoolResource extends Resource
{
    public function __construct(
        Client $client,
        protected readonly School $school,
    ) {
        parent::__construct($client);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri(
            "schools/{$this->school->id}" . ($path ? "/{$path}" : ''),
            $version,
        )->withHost($this->school->region->domain);
    }
}
