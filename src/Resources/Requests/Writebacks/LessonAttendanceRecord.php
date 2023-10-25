<?php

declare(strict_types=1);

namespace Wonde\Resources\Requests\Writebacks;

class LessonAttendanceRecord implements \JsonSerializable
{
    public function __construct(
        public string $studentId,
        public string $lessonId,
        public string $attendanceCodeId,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'lesson_id' => $this->lessonId,
            'student_id' => $this->studentId,
            'attendance_code_id' => $this->attendanceCodeId,
        ];
    }
}
