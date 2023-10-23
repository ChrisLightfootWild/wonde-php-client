<?php

declare(strict_types=1);

namespace Wonde\Tests\Feature\Resources;

use Psr\Http\Message\StreamInterface;
use Wonde\Entities\Collections\Schools;
use Wonde\Resources\QueryParameters\Pagination;
use Wonde\Tests\Feature\TestCase;

class PaginationTest extends TestCase
{
    /** @test */
    public function it_can_paginate_results()
    {
        $pageLoader = fn (int $page): StreamInterface => $this->httpFactory->createStreamFromFile(
            __DIR__ . "/../../Fixtures/v1.0/schools/all/page-{$page}.json",
        );

        for ($i = 1; $i <= 3; $i++) {
            $this->mockHttpClient->addResponse(
                $this->httpFactory->createResponse()->withBody($pageLoader($i))
            );
        }

        $schools = $this->client->schools->all(new Pagination(perPage: 1));

        self::assertInstanceOf(Schools::class, $schools);
        self::assertCount(3, $schools);
    }
}
