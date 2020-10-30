<?php

namespace Domain\UseCase;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

/**
 * Class UseCaseTest
 * @package Domain\UseCase
 */
class UseCaseTest extends TestCase
{
    private UseCase $sut;

    public function setUp(): void
    {
        $entity_manager = $this->createMock(EntityManager::class);

        /** @var EntityManager $entity_manager */
        $this->sut = new UseCase($entity_manager);
    }

    public function test_assert_use_case_starts_with_entity_manager_set(): void
    {
        self::assertNotNull($this->sut->getEntityManager());
    }
}