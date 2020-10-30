<?php

namespace Tests\Domain\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\User;
use Domain\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class UserRepositoryTest
 * @package Tests\Domain\Repository
 */
class UserRepositoryTest extends TestCase
{
    private UserRepository $sut;

    public function setUp(): void
    {
        $entity_manager = $this->createMock(EntityManager::class);
        $entity_manager->method('persist');
        $this->sut = new UserRepository($entity_manager);
    }

    /** @throws ORMException */
    public function test_assert_create(): void
    {
        $user = $this->createMock(User::class);
        $this->sut->create($user);
        $this->addToAssertionCount(1);
    }
}