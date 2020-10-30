<?php

namespace Domain\Repository;

use DateTime;
use Domain\Entity\User;
use Doctrine\ORM\ORMException;
use Domain\Repository\Interfaces\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package Domain\Repository
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * @param User $user
     * @throws ORMException
     */
    public function create(User $user): void
    {
        $now = new DateTime('now');

        $this
            ->getEntityManager()
            ->persist(
                $user
                    ->setCreatedAt($now)
                    ->setUpdatedAt($now)
            );
    }
}