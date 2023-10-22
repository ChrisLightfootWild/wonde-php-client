<?php

namespace Wonde\Entities\Collections;

use Wonde\Entities\AttendanceCode;

class AttendanceCodes extends Collection
{
    public function current(): AttendanceCode
    {
        return parent::current();
    }
}
