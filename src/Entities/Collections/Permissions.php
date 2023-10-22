<?php

namespace Wonde\Entities\Collections;

use Wonde\Entities\Meta\Permission;

class Permissions extends Collection
{
    public function current(): Permission
    {
        return parent::current();
    }
}
