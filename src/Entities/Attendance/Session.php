<?php

declare(strict_types=1);

namespace Wonde\Entities\Attendance;

enum Session: string
{
    case AM = 'AM';
    case PM = 'PM';
}
