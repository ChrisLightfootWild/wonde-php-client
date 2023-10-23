<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\Collections\Permissions;
use Wonde\Entities\Meta\AccessControlList;
use Wonde\Entities\Meta\Permission;
use Wonde\Entities\Meta\School;
use Wonde\Util\JSON;

class Meta extends Resource
{
    public function accessControlList(string $schoolId): AccessControlList
    {
        $json = JSON::decodeFromResponse($this->getRaw("{$schoolId}/acl", [
            'with_user_type' => true,
        ]));

        return AccessControlList::fromData($json['data']);
    }

    public function permissions(string $schoolId): Permissions
    {
        $json = JSON::decodeFromResponse($this->getRaw("{$schoolId}/permissions"));
        $permissions = [];

        foreach ($json['data'] as $item) {
            $permissions[] = Permission::fromData($item);
        }

        return new Permissions(...$permissions);
    }

    public function school(string $schoolId): School
    {
        $json = JSON::decodeFromResponse($this->getRaw($schoolId));

        return School::fromData($json['data']);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri("meta/schools/{$path}", $version);
    }
}
