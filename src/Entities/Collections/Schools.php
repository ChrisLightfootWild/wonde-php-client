<?php

namespace Wonde\Entities\Collections;

use Wonde\Entities\School;

class Schools extends Collection
{
    public function current(): School
    {
        return parent::current();
    }
}
