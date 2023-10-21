<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

class Extended
{
    public function __construct(
        public bool $allowsWriteback = false,
        public bool $hasTimetables = false,
        public bool $hasLessonAttendance = false,
        public ?\DateTimeImmutable $auditApprovedAt = null,
    ) {
    }

    public static function fromData(array $data): self
    {
        return new self(
            allowsWriteback: $data['allows_writeback'],
            hasTimetables: $data['has_timetables'],
            hasLessonAttendance: $data['has_lesson_attendance'],
            auditApprovedAt: !isset($data['audit_approved_at']) ? null : new \DateTimeImmutable(
                $data['audit_approved_at']['date'],
                new \DateTimeZone($data['audit_approved_at']['timezone']),
            ),
        );
    }
}
