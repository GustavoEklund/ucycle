<?php

namespace Domain\UseCase\User;

use Doctrine\ORM\ORMException;
use Domain\Entity\User;
use Domain\Repository\UserRepository;
use Domain\UseCase\UseCase;

/**
 * Class UpdateUser
 * @package Domain\UseCase\User
 */
class UpdateUser extends UseCase
{
    /**
     * @param User $user
     * @throws ORMException
     */
    public function execute(User $user): void
    {
        /** @var UserRepository $user_repository */
        $user_repository = $this
            ->getEntityManager()
            ->getRepository(User::class);

        $user_repository->update($user);
    }
}