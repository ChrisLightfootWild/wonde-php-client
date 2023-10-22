<?php

declare(strict_types=1);

namespace Wonde\Entities\Meta;

use Wonde\Entities\AccessControl;
use Wonde\Entities\Collections\AccessControl as AccessControlCollection;

class AccessControlList
{
    public function __construct(
        public readonly ?string $mode,
        public readonly AccessControlCollection $accessControl,
    ) {
    }

    public static function fromData(array $data): self
    {
        $acl = [];
        foreach ($data['ids'] as $item) {
            $acl[] = AccessControl::fromData($item);
        }

        return new self(
            $data['mode'] ?? null,
            new AccessControlCollection(...$acl),
        );
    }
}
