<?php

declare(strict_types=1);

namespace Wonde\Entities\Meta;

class Permission
{
    public function __construct(
        public string $identity,
        public string $name,
        public string $description,
        public ?string $parent,
        public string $group,
        public \DateTimeImmutable $activeFrom,
        public bool $optional = false,
        public bool $approved = false,
        public bool $audited = false,
        public bool $declined = false,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            $data['identity'],
            $data['name'],
            $data['description'],
            $data['parent'],
            $data['group'],
            new \DateTimeImmutable($data['active_from']['date'], new \DateTimeZone($data['active_from']['timezone'])),
            $data['optional'],
            $data['approved'],
            // TODO: clarify mismatch in the docs
            audited: $data['audited'] ?? false,
            declined: $data['declined'] ?? false,
        );
    }
}
