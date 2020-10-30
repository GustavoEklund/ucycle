<?php

namespace Domain\UseCase\User;

use Doctrine\ORM\ORMException;
use Domain\Entity\User;
use Domain\Exception\RequiredValueException;
use Domain\Repository\UserRepository;
use Domain\UseCase\UseCase;
use InvalidArgumentException;

/**
 * Class CreateUser
 * @package Domain\UseCase\User
 */
class CreateUser extends UseCase
{
    /**
     * @param User $user
     * @param string $password
     * @throws ORMException
     */
    public function execute(User $user, string $password): void
    {
        if (empty($user->getFullName())) {
            throw new RequiredValueException('Nome completo', 500);
        }

        if (empty($user->getEmail())) {
            throw new RequiredValueException('Email', 500);
        }

        if (!$user->isPasswordValid($password)) {
            throw new InvalidArgumentException('Senha inválida.', 500);
        }

        if ($user->getCreatedBy() === null) {
            throw new RequiredValueException('Criado por', 500);
        }

        if ($user->getUpdatedBy() === null) {
            throw new RequiredValueException('Atualizado por', 500);
        }

        /** @var UserRepository $user_repository */
        $user_repository = $this
            ->getEntityManager()
            ->getRepository(User::class);

        $user_repository->create($user);
    }
}