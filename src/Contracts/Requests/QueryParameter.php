<?php

declare(strict_types=1);

namespace Wonde\Contracts\Requests;

interface QueryParameter
{
    public function toQueryString(): array;
}
