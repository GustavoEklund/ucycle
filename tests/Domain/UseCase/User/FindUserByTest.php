<?php

namespace Tests\Domain\UseCase\User;

use Doctrine\ORM\EntityManager;
use Domain\Entity\User;
use Domain\Repository\UserRepository;
use Domain\UseCase\User\FindUserBy;
use PHPUnit\Framework\TestCase;

/**
 * Class FindUserByTest
 * @package Tests\Domain\UseCase\User
 */
class FindUserByTest extends TestCase
{
    private FindUserBy $sut;
    private UserRepository $user_repository;

    public function setUp(): void
    {
        $this->user_repository = $this->createMock(UserRepository::class);

        $entity_manager = $this->createMock(EntityManager::class);
        $entity_manager
            ->expects(self::once())
            ->method('getRepository')
            ->with(...[])
            ->willReturn($this->user_repository);

        $this->sut = new FindUserBy($entity_manager);
    }

    public function test_assert_get_array_of_users_if_found(): void
    {
        $this
            ->user_repository
            ->expects(self::once())
            ->method('findBy')
            ->with(...[['email' => 'any_email@example.com'], [], null, null])
            ->willReturn([new User]);

        $this->sut->execute(['email' => 'any_email@example.com']);
    }
}