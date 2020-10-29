<?php

namespace Domain\Repository;

use Doctrine\ORM\EntityManager;

/**
 * Class Repository
 * @package Domain\Repository
 */
class Repository
{
    private EntityManager $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entity_manager;
    }
}