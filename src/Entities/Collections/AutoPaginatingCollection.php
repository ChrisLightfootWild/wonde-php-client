<?php

namespace Wonde\Entities\Collections;

use Psr\Http\Message\ResponseInterface;
use Wonde\Client;
use Wonde\Entities\Meta\Pagination;

abstract class AutoPaginatingCollection extends Collection
{
    protected \Closure $hydrator;

    public function __construct(
        private readonly Client $client,
        private Pagination $pagination,
        mixed ...$item,
    ) {
        parent::__construct(...$item);

        $this->hydrator = fn (mixed $item) => $item;
    }

    public function hydrateWith(\Closure $hydrator): static
    {
        $this->hydrator = $hydrator;

        return $this;
    }

    public function valid(): bool
    {
        if (parent::valid()) {
            return true;
        }

        if (! $this->pagination->more) {
            return false;
        }

        /** @var ResponseInterface $response */
        $response = $this->client->httpAsyncClient->sendAsyncRequest(
            $this->client->requestFactory->createRequest('GET', $this->pagination->next),
        )->wait();

        $json = json_decode((string) $response->getBody(), true);
        $this->pagination = Pagination::fromData($json['meta']['pagination']);

        foreach ($json['data'] as $item) {
            $this->items[] = ($this->hydrator)($item);
        }

        $maxItems = $this->client->options->maximumItemsInAutoPaginatingCollection;
        $this->items = array_slice(
            $this->items,
            // Keep the last X number of items.
            offset: is_null($maxItems) ? 0 : -($maxItems),
            length: $maxItems,
            preserve_keys: true,
        );

        return parent::valid();
    }
}
