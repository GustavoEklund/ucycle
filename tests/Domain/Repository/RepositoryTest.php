<?php

namespace Tests\Domain\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Domain\Repository\Repository;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * Class RepositoryTest
 * @package Tests\Domain\Repository
 */
final class RepositoryTest extends TestCase
{
    private Repository $sut;
    private EntityManager $entity_manager;

    public function setUp(): void
    {
        $this->entity_manager = $this->createMock(EntityManager::class);

        $this->sut = new Repository($this->entity_manager);
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

    public function test_assert_get_self_class_alias_if_not_defined(): void
    {
        self::assertEquals('r', $this->sut->getClassAlias());
    }

    /**
     * @throws ReflectionException
     */
    public function test_assert_can_set_class_alias_and_turns_to_lowercase(): void
    {
        $reflection = new ReflectionClass(get_class($this->sut));

        $method = $reflection->getMethod('setClassName');
        $method->setAccessible(true);
        $method->invokeArgs($this->sut, [__CLASS__]);

        $set_class_alias = $reflection->getMethod('setClassAlias');
        $set_class_alias->setAccessible(true);
        $set_class_alias->invokeArgs($this->sut, [__CLASS__]);

        self::assertEquals('r', $this->sut->getClassAlias());
    }

    public function test_assert_findBy_returns_empty_array_if_not_found(): void
    {
        // Arrange
        $query_builder = $this->createMock(QueryBuilder::class);
        $query_builder
            ->expects(self::once())
            ->method('select')
            ->with(...[$this->sut->getClassAlias()])
            ->willReturn($query_builder);
        $query_builder
            ->expects(self::once())
            ->method('from')
            ->with(...[$this->sut->getClassName(), $this->sut->getClassAlias()])
            ->willReturn($query_builder);
        $query_builder
            ->expects(self::once())
            ->method('setFirstResult')
            ->with(...[null])
            ->willReturn($query_builder);
        $query_builder
            ->expects(self::once())
            ->method('setMaxResults')
            ->with(...[null])
            ->willReturn($query_builder);
        $query_builder
            ->expects(self::once())
            ->method('andWhere')
            ->with(...['r.test = :test'])
            ->willReturn($query_builder);
        $query_builder
            ->expects(self::once())
            ->method('setParameter')
            ->with(...['test', 'test'])
            ->willReturn($query_builder);
        $query_builder
            ->expects(self::once())
            ->method('addOrderBy')
            ->with(...['r.test', 'DESC'])
            ->willReturn($query_builder);
        $abstract_query = $this
            ->getMockBuilder(AbstractQuery::class)
            ->onlyMethods(['getResult'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $abstract_query
            ->expects(self::once())
            ->method('getResult')
            ->with(...[AbstractQuery::HYDRATE_ARRAY])
            ->willReturn([]);
        $query_builder
            ->expects(self::once())
            ->method('getQuery')
            ->with(...[])
            ->willReturn($abstract_query);

        $this
            ->entity_manager
            ->expects(self::once())
            ->method('createQueryBuilder')
            ->with(...[])
            ->willReturn($query_builder);

        // Act, Assert
        $this->sut->findBy(['test' => 'test'], ['test' => 'DESC']);
    }
}