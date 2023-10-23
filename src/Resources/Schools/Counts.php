<?php

declare(strict_types=1);

namespace Wonde\Resources\Schools;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\Collections\ResourceCounter;
use Wonde\Entities\ResourceCount;
use Wonde\Resources\QueryParameters\Includes;
use Wonde\Util\JSON;

class Counts extends SchoolResource
{
    public function get(Includes $includes = null): ResourceCounter
    {
        $json = JSON::decodeFromResponse(
            $this->getRaw(parameters: $includes->toQueryString()),
        );

        $counts = [];
        foreach ($json['data'] as $resource => $data) {
            $counts[] = new ResourceCount($resource, $data['data']['count']);
        }

        return new ResourceCounter(...$counts);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri('counts', $version);
    }
}
