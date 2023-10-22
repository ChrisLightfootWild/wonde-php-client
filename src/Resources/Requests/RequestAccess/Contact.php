<?php

declare(strict_types=1);

namespace Wonde\Resources\Requests\RequestAccess;

class Contact implements \JsonSerializable
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public ?string $phoneNumber = null,
        public ?string $emailAddress = null,
        public ?string $notes = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone_number' => $this->phoneNumber,
            'email_address' => $this->emailAddress,
            'notes' => $this->notes,
        ];
    }
}
