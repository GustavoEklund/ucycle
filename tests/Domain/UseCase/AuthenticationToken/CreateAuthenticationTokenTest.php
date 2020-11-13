<?php

namespace Tests\Domain\UseCase\AuthenticationToken;

use Doctrine\ORM\EntityManager;
use Domain\Entity\AuthenticationToken;
use Domain\Exception\RequiredValueException;
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

    public function test_assert_given_auth_token_without_subject_throws_exception(): void
    {
        // Arrange
        $this->expectException(RequiredValueException::class);
        $this->expectExceptionMessage('Sujeito');
        $this->expectExceptionCode(500);

        $auth_token = new AuthenticationToken;

        $this->sut->execute($auth_token);
    }
}