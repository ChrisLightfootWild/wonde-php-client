<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\Collections\Schools as SchoolCollection;
use Wonde\Entities\School;

class Schools extends Resource
{
    public function get(string $id): School
    {
        $response = $this->getRaw($id);
        $decoded = $this->decodeJsonBody($response);

        return School::fromData($decoded['data']);
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
        return $this->getSchools('search');
    }

    public function requestAccess(string $schoolId, $payload = [])
    {
        // TODO
    }

    public function revokeAccess(string $schoolId)
    {
        // TODO
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri("schools/{$path}", $version);
    }

    private function getSchools(string $path = '', array $parameters = []): SchoolCollection
    {
        $decoded = $this->decodeJsonBody($this->getRaw($path, $parameters));
        $schools = [];

        foreach ($decoded['data'] as $school) {
            $schools[] = School::fromData($school);
        }

        return new SchoolCollection(...$schools);
    }
}
