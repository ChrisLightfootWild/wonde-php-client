<?php

declare(strict_types=1);

namespace Wonde\Entities\Meta;

class School
{
    public function __construct(
        public bool $online = false,
        public bool $approved = false,
        public bool $audited = false,
        public bool $customAttendanceCodes = false,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            $data['online'],
            $data['approved'],
            $data['audited'],
            $data['custom_attendance_codes'],
        );
    }
}
