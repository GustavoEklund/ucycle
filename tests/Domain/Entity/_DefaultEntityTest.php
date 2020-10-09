<?php

namespace Domain\Entity;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\{
    Uuid,
    UuidInterface,
};

/**
 * Class _DefaultEntityTest
 * @package Domain\Entity
 */
class _DefaultEntityTest extends TestCase
{
    private _DefaultEntity $sut;

    public function setUp(): void
    {
        $this->sut = new _DefaultEntity;
    }

    public function test_assert_entity_starts_with_uuid(): void
    {
        self::assertNotEmpty($this->sut->getUuid());
    }

    public function test_can_set_valid_uuid(): void
    {
        // Arrange
        /** @var Uuid $uuid_stub */
        $uuid_stub = $this->createMock(UuidInterface::class);

        // Act
        $this->sut->setUuid($uuid_stub);

        // Assert
        self::assertEquals($uuid_stub, $this->sut->getUuid());
    }

    public function test_assert_entity_starts_with_active_true_status(): void
    {
        self::assertTrue($this->sut->isActive());
    }

    public function test_can_set_active_status(): void
    {
        // Arrange
        $active = false;

        // Act
        $this->sut->setActive($active);

        // Assert
        self::assertEquals($active, $this->sut->isActive());
    }
}