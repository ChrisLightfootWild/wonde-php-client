<?php

declare(strict_types=1);

namespace Wonde\Resources\Schools;

use Psr\Http\Message\UriInterface;
use Wonde\Entities\AttendanceCode;
use Wonde\Entities\Collections\AttendanceCodes as AttendanceCodesCollection;
use Wonde\Util\JSON;

class AttendanceCodes extends SchoolResource
{
    public function get(): AttendanceCodesCollection
    {
        $json = JSON::decodeFromResponse($this->getRaw());
        $attendanceCodes = [];

        foreach ($json['data'] ?? [] as $item) {
            $attendanceCodes[] = AttendanceCode::fromData($item);
        }

        return new AttendanceCodesCollection(...$attendanceCodes);
    }

    protected function buildUri(string $path = '', string $version = 'v1.0'): UriInterface
    {
        return parent::buildUri('attendance-codes', $version);
    }
}
