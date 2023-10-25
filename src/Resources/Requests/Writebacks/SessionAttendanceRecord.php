<?php

declare(strict_types=1);

namespace Wonde\Resources\Requests\Writebacks;

use Wonde\Entities\Attendance\Session;

class SessionAttendanceRecord implements \JsonSerializable
{
    public function __construct(
        public string $studentId,
        public \DateTimeImmutable $date,
        public Session $session,
        public string $attendanceCodeId,
        public ?string $comment = null,
        public int $minutesLate = 0,
        public ?string $employeeId = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        $data = [
            'date' => $this->date->format('Y-m-d'),
            'session' => $this->session,
            'student_id' => $this->studentId,
            'attendance_code_id' => $this->attendanceCodeId,
        ];

        if ($this->comment) {
            $data['comment'] = $this->comment;
        }

        if ($this->employeeId) {
            $data['employee_id'] = $this->employeeId;
        }

        if ($this->minutesLate > 0) {
            $data['minutes_late'] = $this->minutesLate;
        }

        return $data;
    }
}
