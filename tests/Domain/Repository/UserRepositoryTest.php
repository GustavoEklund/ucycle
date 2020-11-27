<?php

namespace Tests\Domain\Repository;

use DateTime;
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
    private EntityManager $entity_manager;

    public function setUp(): void
    {
        $this->entity_manager = $this->createMock(EntityManager::class);
        $this->entity_manager->method('persist');
        $this->sut = new UserRepository($this->entity_manager);
    }

    public function test_assert_stats_with_User_class_name_set(): void
    {
        self::assertEquals(User::class, $this->sut->getClassName());
    }
    
    /** @throws ORMException */
    public function test_assert_create(): void
    {
        $user = $this->createMock(User::class);
        $this->sut->create($user);
        $this->addToAssertionCount(1);
    }

    /**
     * @throws ORMException
     */
    public function test_assert_update_calls_persist_with_correct_params(): void
    {
        // Arrange
        $user = new User;

        $this
            ->entity_manager
            ->expects(self::once())
            ->method('persist')
            ->with($user);

        // Act, Assert
        $this->sut->update($user);
    }

    /**
     * @throws ORMException
     */
    public function test_assert_update_set_updated_at_to_now_before_persist(): void
    {
        // Arrange
        $user = (new User)->setUpdatedAt(new DateTime('now + 1 hour'));

        // Act
        $this->sut->update($user);

        // Assert
        self::assertEquals(
            (new DateTime('now'))->getTimestamp(),
            $user->getUpdatedAt()->getTimestamp()
        );
    }
}