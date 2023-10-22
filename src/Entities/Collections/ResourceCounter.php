<?php

namespace Wonde\Entities\Collections;

use Wonde\Entities\ResourceCount;

class ResourceCounter extends Collection
{
    public function current(): ResourceCount
    {
        return parent::current();
    }
}
