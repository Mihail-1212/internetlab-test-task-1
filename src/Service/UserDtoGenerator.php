<?php

namespace App\Service;

use App\Dto\CreateUserDto;
use App\Dto\CurrentUserDto;
use App\Dto\GetUserDto;
use App\Dto\UpdateUserDto;
use App\Entity\User;

class UserDtoGenerator
{
    public function createUserFromCreateUserDto(CreateUserDto $createUserDto): User
    {
        $user = new User();

        $user->setUsername($createUserDto->username)
            ->setLastName($createUserDto->lastName)
            ->setFirstName($createUserDto->firstName)
            ->setSecondName($createUserDto->secondName);

        return $user;
    }

    public function updateUserFromUpdateUserDto(User $user, UpdateUserDto $updateUserDto)
    {
        $user->setUsername($updateUserDto->username)
            ->setLastName($updateUserDto->lastName)
            ->setFirstName($updateUserDto->firstName)
            ->setSecondName($updateUserDto->secondName);

        return $user;
    }

    public function createGetUserDtoFromUser(User $user): GetUserDto
    {
        return new GetUserDto(
            id: $user->getId(),
            username: $user->getUsername(),
            lastName: $user->getLastName(),
            firstName: $user->getFirstName(),
            secondName: $user->getSecondName(),
        );
    }

    public function createCurrentUserDtoFromUser(User $user): CurrentUserDto
    {
        return new CurrentUserDto(
            id: $user->getId(),
            username: $user->getUsername(),
            lastName: $user->getLastName(),
            firstName: $user->getFirstName(),
            secondName: $user->getSecondName(),
            createdAt: $user->getCreatedAt(),
            updatedAt: $user->getUpdatedAt(),
        );
    }
}