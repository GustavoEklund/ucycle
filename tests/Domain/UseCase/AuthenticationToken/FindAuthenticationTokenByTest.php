<?php

namespace Tests\Domain\UseCase\AuthenticationToken;

use Doctrine\ORM\EntityManager;
use Domain\Entity\AuthenticationToken;
use Domain\Repository\AuthenticationTokenRepository;
use Domain\UseCase\AuthenticationToken\FindAuthenticationTokenBy;
use PHPUnit\Framework\TestCase;

/**
 * Class FindAuthenticationTokenByTest
 * @package Tests\Domain\UseCase\AuthenticationToken
 */
class FindAuthenticationTokenByTest extends TestCase
{
    private FindAuthenticationTokenBy $sut;
    private EntityManager $entity_manager;

    public function setUp(): void
    {
        $this->entity_manager = $this->createMock(EntityManager::class);
        $this->sut = new FindAuthenticationTokenBy($this->entity_manager);
    }

    public function test_assert_execute_returns_array_of_auth_token_if_found(): void
    {
        $auth_token = new AuthenticationToken;

        $auth_token_repository = $this
            ->createMock(AuthenticationTokenRepository::class);
        $auth_token_repository
            ->expects(self::once())
            ->method('findBy')
            ->with(['sub' => 'any_uuid'], [], null, null)
            ->willReturn([$auth_token]);

        $this
            ->entity_manager
            ->expects(self::once())
            ->method('getRepository')
            ->with(AuthenticationToken::class)
            ->willReturn($auth_token_repository);

        self::assertEquals(
            [$auth_token],
            $this->sut->execute(['sub' => 'any_uuid'])
        );
    }

    public function test_assert_execute_returns_empty_array_if_no_auth_token_found(): void
    {
        $auth_token_repository = $this
            ->createMock(AuthenticationTokenRepository::class);
        $auth_token_repository
            ->expects(self::once())
            ->method('findBy')
            ->with(['sub' => 'any_uuid'], [], null, null)
            ->willReturn([]);

        $this
            ->entity_manager
            ->expects(self::once())
            ->method('getRepository')
            ->with(AuthenticationToken::class)
            ->willReturn($auth_token_repository);

        self::assertEmpty($this->sut->execute(['sub' => 'any_uuid']));
    }
}