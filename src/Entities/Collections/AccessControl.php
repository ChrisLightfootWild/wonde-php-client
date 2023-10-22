<?php

namespace Wonde\Entities\Collections;

use Wonde\Entities\AccessControl as AccessControlEntity;

class AccessControl extends Collection
{
    public function current(): AccessControlEntity
    {
        return parent::current();
    }
}
