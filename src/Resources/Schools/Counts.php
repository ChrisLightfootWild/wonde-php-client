<?php

declare(strict_types=1);

namespace Wonde\Resources\Schools;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\Collections\ResourceCounter;
use Wonde\Entities\ResourceCount;
use Wonde\Resources\QueryParameters\Includes;

class Counts extends SchoolResource
{
    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri('counts', $version);
    }

    public function get(Includes $includes = null): ResourceCounter
    {
        $json = $this->decodeJsonBody(
            $this->getRaw(parameters: ['include' => (string) $includes]),
        );

        $counts = [];
        foreach ($json['data'] as $resource => $data) {
            $counts[] = new ResourceCount($resource, $data['data']['count']);
        }

        return new ResourceCounter(...$counts);
    }
}
