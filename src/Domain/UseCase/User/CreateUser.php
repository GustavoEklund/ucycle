<?php

namespace Domain\UseCase\User;

use Domain\Entity\User;
use Domain\Exception\RequiredValueException;
use Domain\UseCase\UseCase;
use InvalidArgumentException;

/**
 * Class CreateUser
 * @package Domain\UseCase\User
 */
class CreateUser extends UseCase
{
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
    }
}