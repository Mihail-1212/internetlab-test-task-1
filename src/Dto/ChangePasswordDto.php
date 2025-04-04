<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ChangePasswordDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Password cannot be blank')]
        #[Assert\PasswordStrength]
        public readonly ?string $password,
    )
    {

    }
}