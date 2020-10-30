<?php

namespace Domain\UseCase\User;

use Domain\Entity\User;
use Domain\Exception\RequiredValueException;
use Domain\UseCase\UseCase;

/**
 * Class CreateUser
 * @package Domain\UseCase\User
 */
class CreateUser extends UseCase
{
    public function execute(User $user): void
    {
        if (empty($user->getFullName())) {
            throw new RequiredValueException('Nome completo', 500);
        }
    }
}