<?php

namespace App\Dto;

class CurrentUserDto
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $username,
        public readonly ?string $lastName,
        public readonly ?string $firstName,
        public readonly ?string $secondName,
        public readonly ?\DateTime $createdAt,
        public readonly ?\DateTime $updatedAt,
    )
    {
    }
}