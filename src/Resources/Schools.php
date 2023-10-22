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
        $decoded = $this->decodeJsonBody($this->getRaw('all'));
        $schools = [];

        foreach ($decoded['data'] as $school) {
            $schools[] = School::fromData($school);
        }

        return new SchoolCollection(...$schools);
    }

    public function approved(): SchoolCollection
    {
        return $this->all();
    }

    public function audited(): SchoolCollection
    {
        return $this->all();
    }

    public function offline(): SchoolCollection
    {
        return $this->all();
    }

    public function pending(): SchoolCollection
    {
        return $this->all();
    }

    public function revoked(): SchoolCollection
    {
        return $this->all();
    }

    public function declined(): SchoolCollection
    {
        return $this->all();
    }

    public function search(): SchoolCollection
    {
        return $this->all();
    }

    public function requestAccess(string $schoolId, $payload = [])
    {
        //
    }

    public function revokeAccess(string $schoolId)
    {
        //
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri("schools/{$path}", $version);
    }
}
