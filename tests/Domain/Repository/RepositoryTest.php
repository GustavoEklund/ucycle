<?php

namespace Tests\Domain\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Domain\Repository\Repository;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

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

    /**
     * @throws ReflectionException
     */
    public function test_can_set_class_name(): void
    {
        $reflection = new ReflectionClass(get_class($this->sut));
        $method = $reflection->getMethod('setClassName');
        $method->setAccessible(true);
        $method->invokeArgs($this->sut, [__CLASS__]);

        self::assertEquals(__CLASS__, $this->sut->getClassName());
    }

    /**
     * @throws ReflectionException
     */
    public function test_assert_setClassName_calls_setClassAlias(): void
    {
        $reflection = new ReflectionClass(get_class($this->sut));
        $method = $reflection->getMethod('setClassName');
        $method->setAccessible(true);
        $method->invokeArgs($this->sut, [__CLASS__]);

        self::assertEquals('r', $this->sut->getClassAlias());
    }

    public function test_assert_get_hydration_array_mode_as_default(): void
    {
        self::assertEquals(AbstractQuery::HYDRATE_ARRAY, $this->sut->getHydrationMode());
    }

    public function test_can_set_hydration_mode(): void
    {
        // Arrange, Act
        $this->sut->setHydrationMode(AbstractQuery::HYDRATE_OBJECT);

        // Assert
        self::assertEquals(
            AbstractQuery::HYDRATE_OBJECT,
            $this->sut->getHydrationMode()
        );
    }
}