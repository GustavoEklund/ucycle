<?php

namespace Domain\Repository;

use DateTime;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Domain\Entity\User;
use Doctrine\ORM\ORMException;
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
}