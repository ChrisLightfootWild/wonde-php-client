<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class Extended
{
    public function __construct(
        public bool $allowsWriteback = false,
        public bool $hasTimetables = false,
        public bool $hasLessonAttendance = false,
    ) {
    }
}
