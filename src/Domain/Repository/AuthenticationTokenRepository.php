<?php

namespace Domain\Repository;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\AuthenticationToken;

/**
 * Class AuthenticationTokenRepository
 * @package Domain\Repository
 */
class AuthenticationTokenRepository extends Repository implements Interfaces\AuthenticationTokenRepositoryInterface
{
    public function __construct(EntityManager $entity_manager)
    {
        parent::__construct($entity_manager);
        $this->setClassName(AuthenticationToken::class);
    }

    /**
     * @param AuthenticationToken $auth_token
     * @throws ORMException
     */
    public function create(AuthenticationToken $auth_token): void
    {
        $now = new DateTime('now');

        $this
            ->getEntityManager()
            ->persist(
                $auth_token
                    ->setCreatedAt($now)
                    ->setUpdatedAt($now)
            );
    }

    /**
     * @param AuthenticationToken $auth_token
     * @throws ORMException
     */
    public function remove(AuthenticationToken $auth_token): void
    {
        $this
            ->getEntityManager()
            ->remove($auth_token);
    }
}