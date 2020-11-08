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
    private string $class_name;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
        $this->class_name = self::class;
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entity_manager;
    }

    public function getClassName(): string
    {
        return $this->class_name;
    }

    protected function setClassName(string $class_name): Repository
    {
        $this->class_name = $class_name;
        return $this;
    }
}