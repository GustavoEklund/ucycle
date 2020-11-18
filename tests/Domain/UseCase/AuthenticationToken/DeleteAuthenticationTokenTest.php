<?php

namespace Domain\UseCase\AuthenticationToken;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\AuthenticationToken;
use Domain\Repository\AuthenticationTokenRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteAuthenticationTokenTest
 * @package Domain\UseCase\AuthenticationToken
 */
class DeleteAuthenticationTokenTest extends TestCase
{
    /** @throws ORMException */
    public function test_assert_remove_is_called(): void
    {
        // Arrange
        $auth_token = new AuthenticationToken;

        $auth_token_repository = $this
            ->createMock(AuthenticationTokenRepository::class);

        $auth_token_repository
            ->expects(self::once())
            ->method('remove')
            ->with($auth_token);

        $entity_manager = $this
            ->createMock(EntityManager::class);
        $entity_manager
            ->expects(self::once())
            ->method('getRepository')
            ->with(AuthenticationToken::class)
            ->willReturn($auth_token_repository);

        $sut = new DeleteAuthenticationToken($entity_manager);
        $sut->execute($auth_token);
    }
}