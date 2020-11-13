<?php

namespace Tests\Domain\UseCase\AuthenticationToken;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\AuthenticationToken;
use Domain\Entity\User;
use Domain\Exception\RequiredValueException;
use Domain\Repository\AuthenticationTokenRepository;
use Domain\UseCase\AuthenticationToken\CreateAuthenticationToken;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateAuthenticationTokenTest
 * @package Tests\Domain\UseCase\AuthenticationToken
 */
class CreateAuthenticationTokenTest extends TestCase
{
    private CreateAuthenticationToken $sut;
    private EntityManager $entity_manager;

    public function setUp(): void
    {
        $this->entity_manager = $this->createMock(EntityManager::class);
        $this->sut = new CreateAuthenticationToken($this->entity_manager);
    }

    /** @throws ORMException */
    public function test_assert_given_auth_token_without_subject_throws_exception(): void
    {
        // Arrange
        $this->expectException(RequiredValueException::class);
        $this->expectExceptionMessage('Sujeito');
        $this->expectExceptionCode(500);

        $auth_token = new AuthenticationToken;

        // Act, Assert
        $this->sut->execute($auth_token);
    }

    /** @throws ORMException */
    public function test_assert_given_auth_token_without_created_by_throws_exception(): void
    {
        // Arrange
        $this->expectException(RequiredValueException::class);
        $this->expectExceptionMessage('Criado por');
        $this->expectExceptionCode(500);

        $auth_token = (new AuthenticationToken)
            ->setSub(new User);

        // Act, Assert
        $this->sut->execute($auth_token);
    }

    /** @throws ORMException */
    public function test_assert_given_auth_token_without_updated_by_throws_exception(): void
    {
        // Arrange
        $this->expectException(RequiredValueException::class);
        $this->expectExceptionMessage('Atualizado por');
        $this->expectExceptionCode(500);

        $user = new User;

        $auth_token = (new AuthenticationToken)
            ->setSub($user)
            ->setCreatedBy($user);

        // Act, Assert
        $this->sut->execute($auth_token);
    }

    /** @throws ORMException */
    public function test_assert_execute_calls_create_with_given_auth_token(): void
    {
        // Arrange
        $user = new User;

        $auth_token = (new AuthenticationToken)
            ->setSub($user)
            ->setCreatedBy($user)
            ->setUpdatedBy($user);

        $auth_token_repository = $this->createMock(AuthenticationTokenRepository::class);
        $auth_token_repository
            ->expects(self::once())
            ->method('create')
            ->with($auth_token);

        $this
            ->entity_manager
            ->expects(self::once())
            ->method('getRepository')
            ->with(AuthenticationToken::class)
            ->willReturn($auth_token_repository);

        // Act, Assert
        $this->sut->execute($auth_token);
    }
}