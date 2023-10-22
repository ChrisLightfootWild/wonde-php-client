<?php

declare(strict_types=1);

namespace Wonde\Resources\Requests;

use Wonde\Resources\Requests\RequestAccess\Contact;

class SchoolAccessRequest implements \JsonSerializable
{
    private array $contacts;

    public function __construct(
        Contact ...$contact,
    ) {
        $this->contacts = $contact;
    }

    public function jsonSerialize(): array
    {
        return [
            'contacts' => $this->contacts,
        ];
    }
}
