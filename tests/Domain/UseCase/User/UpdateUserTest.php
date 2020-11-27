<?php

namespace Domain\UseCase\User;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\User;
use Domain\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class UpdateUserTest
 * @package Domain\UseCase\User
 */
class UpdateUserTest extends TestCase
{
    /**
     * @throws ORMException
     */
    public function test_assert_execute_calls_update_with_correct_param(): void
    {
        $user = new User;

        $user_repository = $this->createMock(UserRepository::class);
        $user_repository
            ->expects(self::once())
            ->method('update')
            ->with($user);

        $entity_manager = $this->createMock(EntityManager::class);
        $entity_manager
            ->expects(self::once())
            ->method('getRepository')
            ->with(User::class)
            ->willReturn($user_repository);

        $sut = new UpdateUser($entity_manager);
        $sut->execute($user);
    }
}