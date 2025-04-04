<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Username cannot be blank')]
        public readonly ?string $username,

        #[Assert\NotBlank(message: 'Last name cannot be blank')]
        public readonly ?string $lastName,

        #[Assert\NotBlank(message: 'First name cannot be blank')]
        public readonly ?string $firstName,

        public readonly ?string $secondName
    )
    {
    }
}