<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

enum PhaseOfEducation: string
{
    case NOT_APPLICABLE = 'NOT APPLICABLE';
    case PRIMARY = 'PRIMARY';
    case SECONDARY = 'SECONDARY';
    case SIXTEEN_PLUS = '16 PLUS';
}
