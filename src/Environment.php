<?php

declare(strict_types=1);

namespace Wonde;

enum Environment
{
    case LIVE;

    public function rootDomain(): string
    {
        return match ($this) {
            self::LIVE => 'https://api.wonde.com/',
        };
    }
}
