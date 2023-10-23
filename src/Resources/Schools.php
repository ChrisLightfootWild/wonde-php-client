<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Psr\Http\Message\UriInterface;
use Wonde\Contracts\Requests\QueryParameter;
use Wonde\Entities\Collections\Schools as SchoolCollection;
use Wonde\Entities\Meta\Pagination;
use Wonde\Entities\School;
use Wonde\Entities\School\RequestAccess\Requested;
use Wonde\Entities\School\RequestAccess\Revoked;
use Wonde\Resources\Requests\SchoolAccessRequest;
use Wonde\Util\JSON;

class Schools extends Resource
{
    public function get(string $id): School
    {
        $json = JSON::decodeFromResponse($this->getRaw($id));

        return School::fromData($json['data']);
    }

    public function all(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('all', ...$queryParameter);
    }

    public function approved(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('', ...$queryParameter);
    }

    public function audited(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('audited', ...$queryParameter);
    }

    public function offline(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('offline', ...$queryParameter);
    }

    public function pending(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('pending', ...$queryParameter);
    }

    public function revoked(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('revoked', ...$queryParameter);
    }

    public function declined(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('declined', ...$queryParameter);
    }

    public function search(QueryParameter ...$queryParameter): SchoolCollection
    {
        return $this->getSchools('all', ...$queryParameter);
    }

    public function requestAccess(string $schoolId, SchoolAccessRequest $schoolAccessRequest): Requested
    {
        $stream = $this->client->streamFactory->createStream(json_encode($schoolAccessRequest));

        $json = JSON::decodeFromResponse($this->postRaw("{$schoolId}/request-access", $stream));

        return Requested::fromData($json);
    }

    public function revokeAccess(string $schoolId): Revoked
    {
        $json = JSON::decodeFromResponse($this->deleteRaw("{$schoolId}/revoke-access"));

        return Revoked::fromData($json);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri("schools/{$path}", $version);
    }

    private function getSchools(string $path = '', QueryParameter ...$queryParameter): SchoolCollection
    {
        $parameters = [];
        foreach ($queryParameter as $parameter) {
            foreach ($parameter->toQueryString() as $key => $value) {
                $parameters[$key] = $value;
            }
        }

        $json = JSON::decodeFromResponse($this->getRaw($path, $parameters));
        $schools = [];

        foreach ($json['data'] as $school) {
            $schools[] = School::fromData($school);
        }

        return (new SchoolCollection(
            $this->client,
            Pagination::fromData($json['meta']['pagination']),
            ...$schools,
        ))->hydrateWith(static fn ($data) => School::fromData($data));
    }
}
