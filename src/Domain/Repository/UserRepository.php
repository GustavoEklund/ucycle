<?php

namespace Domain\Repository;

use DateTime;
use Domain\Entity\User;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\AbstractQuery;
use Domain\Repository\Interfaces\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package Domain\Repository
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(EntityManager $entity_manager)
    {
        parent::__construct($entity_manager);
        $this->setClassName(User::class);
        $this->setHydrationMode(AbstractQuery::HYDRATE_OBJECT);
    }

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

    /**
     * @param User $user
     * @throws ORMException
     */
    public function update(User $user): void
    {
        $this
            ->getEntityManager()
            ->persist($user->setUpdatedAt(new DateTime('now')));
    }
}
