<?php

namespace Tests\Domain\Repository;

use Doctrine\ORM\EntityManager;
use Domain\Repository\Repository;
use PHPUnit\Framework\TestCase;

/**
 * Class RepositoryTest
 * @package Tests\Domain\Repository
 */
class RepositoryTest extends TestCase
{
    protected Repository $sut;

    public function setUp(): void
    {
        $entity_manager = $this->createMock(EntityManager::class);

        /** @var EntityManager $entity_manager */
        $this->sut = new Repository($entity_manager);
    }

    public function test_assert_repository_starts_with_entity_manager_set(): void
    {
        self::assertNotNull($this->sut->getEntityManager());
    }

    public function test_assert_get_self_class_name_if_not_defined(): void
    {
        self::assertEquals(Repository::class, $this->sut->getClassName());
    }
}