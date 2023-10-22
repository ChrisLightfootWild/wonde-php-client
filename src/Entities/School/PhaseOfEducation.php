<?php

declare(strict_types=1);

namespace Wonde\Entities\School;

enum PhaseOfEducation: string
{
    case NOT_APPLICABLE = 'NOT APPLICABLE';
    case NOT_APPLICABLE_DEEMED_PRIMARY = 'NOT APPLICABLE DEEMED PRIMARY';
    case NOT_APPLICABLE_DEEMED_SECONDARY = 'NOT APPLICABLE DEEMED SECONDARY';
    case NURSERY = 'NURSERY';
    case PRIMARY = 'PRIMARY';
    case SECONDARY = 'SECONDARY';
    case SIXTEEN_PLUS = '16 PLUS';
}
