<?php

namespace Domain\UseCase;

use Doctrine\ORM\EntityManager;

/**
 * Class UseCase
 * @package Domain\UseCase
 */
class UseCase
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