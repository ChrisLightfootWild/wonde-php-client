<?php

declare(strict_types=1);

namespace Wonde\Resources;

use Wonde\Client;
use Wonde\Entities\School as SchoolEntity;
use Wonde\Resources\Schools\AttendanceCodes;
use Wonde\Resources\Schools\Counts;

class School extends Resource
{
    public AttendanceCodes $attendanceCodes;
    public Counts $counts;

    public function __construct(Client $client, SchoolEntity $school)
    {
        parent::__construct($client);

        $this->buildServicesForSchool($school);
    }

    private function buildServicesForSchool(SchoolEntity $school): void
    {
        $this->attendanceCodes = new AttendanceCodes($this->client, $school);
        $this->counts = new Counts($this->client, $school);
    }
}
