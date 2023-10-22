<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\AttendanceCode;
use Wonde\Entities\Collections\AttendanceCodes as AttendanceCodesCollection;

class AttendanceCodes extends Resource
{
    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri('attendance-codes', $version);
    }

    public function get(): AttendanceCodesCollection
    {
        $json = $this->decodeJsonBody($this->getRaw());
        $attendanceCodes = [];

        foreach ($json['data'] as $item) {
            $attendanceCodes[] = AttendanceCode::fromData($item);
        }

        return new AttendanceCodesCollection(...$attendanceCodes);
    }
}
