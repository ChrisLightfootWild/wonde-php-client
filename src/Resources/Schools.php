<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\Collections\Schools as SchoolCollection;
use Wonde\Entities\School;
use Wonde\Entities\School\RequestAccess\Requested;
use Wonde\Entities\School\RequestAccess\Revoked;
use Wonde\Resources\Requests\SchoolAccessRequest;

class Schools extends Resource
{
    public function get(string $id): School
    {
        $json = $this->decodeJsonBody($this->getRaw($id));

        return School::fromData($json['data']);
    }

    public function all(): SchoolCollection
    {
        return $this->getSchools('all');
    }

    public function approved(): SchoolCollection
    {
        return $this->getSchools();
    }

    public function audited(): SchoolCollection
    {
        return $this->getSchools('audited');
    }

    public function offline(): SchoolCollection
    {
        return $this->getSchools('offline');
    }

    public function pending(): SchoolCollection
    {
        return $this->getSchools('pending');
    }

    public function revoked(): SchoolCollection
    {
        return $this->getSchools('revoked');
    }

    public function declined(): SchoolCollection
    {
        return $this->getSchools('declined');
    }

    public function search(): SchoolCollection
    {
        return $this->getSchools('all');
    }

    public function requestAccess(string $schoolId, SchoolAccessRequest $schoolAccessRequest): Requested
    {
        $stream = $this->client->streamFactory->createStream(json_encode($schoolAccessRequest));

        $json = $this->decodeJsonBody($this->postRaw("{$schoolId}/request-access", $stream));

        return Requested::fromData($json);
    }

    public function revokeAccess(string $schoolId): Revoked
    {
        $json = $this->decodeJsonBody($this->deleteRaw("{$schoolId}/revoke-access"));

        return Revoked::fromData($json);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri("schools/{$path}", $version);
    }

    private function getSchools(string $path = '', array $parameters = []): SchoolCollection
    {
        $json = $this->decodeJsonBody($this->getRaw($path, $parameters));
        $schools = [];

        foreach ($json['data'] as $school) {
            $schools[] = School::fromData($school);
        }

        return new SchoolCollection(...$schools);
    }
}
