<?php

declare(strict_types=1);

namespace Wonde\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wonde\ClientToken;
use Wonde\Exceptions\InvalidTokenException;

class ClientTokenTest extends TestCase
{
    /** @test */
    public function it_prevents_an_empty_string()
    {
        $this->expectException(InvalidTokenException::class);
        new ClientToken('');
    }
}
