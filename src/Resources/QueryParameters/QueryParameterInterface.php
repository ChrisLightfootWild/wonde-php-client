<?php

declare(strict_types=1);

namespace Wonde\Resources\QueryParameters;

interface QueryParameterInterface
{
    public function toQueryString(): array;
}
