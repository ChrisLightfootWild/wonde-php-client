<?php

declare(strict_types=1);

namespace Wonde\Endpoints;

use Wonde\Writeback\LessonRegister;

class LessonAttendance extends BootstrapEndpoint
{
    /**
     * @var string
     */
    public $uri = 'attendance/lesson/';

    /**
     * Lesson Register
     *
     * @param LessonRegister $register
     * @return \stdClass
     */
    public function lessonRegister(LessonRegister $lessonRegister){

        return $this->post($lessonRegister);

    }
}
