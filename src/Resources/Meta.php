<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\Collections\Permissions;
use Wonde\Entities\Meta\AccessControlList;
use Wonde\Entities\Meta\Permission;
use Wonde\Entities\Meta\School;

class Meta extends Resource
{
    public function accessControlList(string $schoolId, bool $withUserType = false): AccessControlList
    {
        $json = $this->decodeJsonBody($this->getRaw("{$schoolId}/acl"));

        return AccessControlList::fromData($json['data']);
    }

    public function permissions(string $schoolId): Permissions
    {
        $json = $this->decodeJsonBody($this->getRaw("{$schoolId}/permissions"));
        $permissions = [];

        foreach ($json['data'] as $item) {
            $permissions[] = Permission::fromData($item);
        }

        return new Permissions(...$permissions);
    }

    public function school(string $schoolId): School
    {
        $json = $this->decodeJsonBody($this->getRaw($schoolId));

        return School::fromData($json['data']);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri("meta/schools/{$path}", $version);
    }
}
