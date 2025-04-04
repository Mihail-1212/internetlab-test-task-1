<?php

namespace App\Controller\Api;

use App\Dto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserDtoGenerator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/user')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface      $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserDtoGenerator            $userDtoGenerator,
        private readonly UserRepository              $userRepository,
    )
    {
    }

    #[Route('/', name: 'app_user_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] Dto\CreateUserDto $createUserDto): JsonResponse
    {
        $user = $this->userDtoGenerator->createUserFromCreateUserDto($createUserDto);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $createUserDto->password);
        $user->setPassword($hashedPassword);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            $message = "User with username '{$user->getUsername()}' already exist";
            throw new UnprocessableEntityHttpException($message, previous: $e);
        }

        $userInfo = $this->userDtoGenerator->createGetUserDtoFromUser($user);
        return $this->json($userInfo);
    }

    #[Route('/', name: 'app_user_list', methods: ['GET'])]
    public function getList(): JsonResponse
    {
        $users = $this->userRepository->findAll();

        $usersDto = [];
        foreach ($users as $user) {
            $usersDto[] = $this->userDtoGenerator->createGetUserDtoFromUser($user);
        }

        return $this->json($usersDto);
    }

    #[Route('/me', name: 'app_user_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $userDto = $this->userDtoGenerator->createCurrentUserDtoFromUser($user);

        return $this->json($userDto);
    }

    #[Route('/{user}', name: 'app_user_update', methods: ['PUT'])]
    public function update(
        User                                   $user,
        #[MapRequestPayload] Dto\UpdateUserDto $updateUserDto
    ): JsonResponse
    {
        $user = $this->userDtoGenerator->updateUserFromUpdateUserDto($user, $updateUserDto);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            $message = "User with username '{$user->getUsername()}' already exist";
            throw new UnprocessableEntityHttpException($message, previous: $e);
        }

        $userInfo = $this->userDtoGenerator->createGetUserDtoFromUser($user);
        return $this->json($userInfo);
    }

    #[Route('/{user}', name: 'app_user_change_password', methods: ['POST'])]
    public function changePassword(
        User                                       $user,
        #[MapRequestPayload] Dto\ChangePasswordDto $changePasswordDto
    ): JsonResponse
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $changePasswordDto->password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userInfo = $this->userDtoGenerator->createGetUserDtoFromUser($user);
        return $this->json($userInfo);
    }

    #[Route('/{user}', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete(User $user): JsonResponse
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(null);
    }
}
