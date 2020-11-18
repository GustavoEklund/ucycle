<?php

namespace Domain\Repository;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\AuthenticationToken;
use PHPUnit\Framework\TestCase;

/**
 * Class AuthenticationTokenRepositoryTest
 * @package Domain\Repository
 */
class AuthenticationTokenRepositoryTest extends TestCase
{
    private AuthenticationTokenRepository $sut;
    private EntityManager $entity_manager;

    public function setUp(): void
    {
        $this->entity_manager = $this->createMock(EntityManager::class);
        $this->entity_manager->method('persist');
        $this->sut = new AuthenticationTokenRepository($this->entity_manager);
    }

    public function test_assert_stats_with_AuthenticationToken_class_name_set(): void
    {
        self::assertEquals(AuthenticationToken::class, $this->sut->getClassName());
    }

    /** @throws ORMException */
    public function test_assert_persist_is_called_with_correct_parameters(): void
    {
        $auth_token = new AuthenticationToken;
        $now = new DateTime('now');

        $this
            ->entity_manager
            ->expects(self::once())
            ->method('persist')
            ->with(
                $auth_token
                    ->setCreatedAt($now)
                    ->setUpdatedAt($now)
            );

        $this->sut->create($auth_token);
    }

    /** @throws ORMException  */
    public function test_assert_remove_calls_remove_with_correct_params(): void
    {
        $auth_token = new AuthenticationToken;

        $this
            ->entity_manager
            ->expects(self::once())
            ->method('remove')
            ->with($auth_token);

        $this->sut->remove($auth_token);
    }
}