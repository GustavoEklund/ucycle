<?php

namespace Tests\Domain\Entity;

use DateTime;
use RangeException;
use Domain\Entity\_DefaultEntity;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\{
    Uuid,
    UuidInterface,
};

/**
 * Class _DefaultEntityTest
 * @package TestsDomain\Entity
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

    public function test_assert_entity_starts_with_created_at_set_to_now(): void
    {
        self::assertEquals(
            (new DateTime('now'))->getTimestamp(),
            $this->sut->getCreatedAt()->getTimestamp()
        );
    }

    public function test_assert_can_set_created_at(): void
    {
        // Arrange
        $date_time = new DateTime('now + 3 days');

        // Act
        $this->sut->setCreatedAt($date_time);

        // Assert
        self::assertEquals(
            $date_time->getTimestamp(),
            $this->sut->getCreatedAt()->getTimestamp()
        );
    }

    public function test_assert_set_created_at_before_now_throws_exception(): void
    {
        // Arrange
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The date time can\'t be before now.');
        $this->expectExceptionCode(500);

        // Act, Assert
        $this->sut->setCreatedAt(new DateTime('2020-01-01'));
    }

    public function test_assert_entity_starts_with_updated_at_set_to_now(): void
    {
        self::assertEquals(
            (new DateTime('now'))->getTimestamp(),
            $this->sut->getUpdatedAt()->getTimestamp()
        );
    }

    public function test_assert_can_set_updated_at(): void
    {
        // Arrange
        $date_time = new DateTime('now + 3 days');

        // Act
        $this->sut->setUpdatedAt($date_time);

        // Assert
        self::assertEquals(
            $date_time->getTimestamp(),
            $this->sut->getUpdatedAt()->getTimestamp()
        );
    }

    public function test_assert_set_updated_at_before_now_throws_exception(): void
    {
        // Arrange
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The date time can\'t be before now.');
        $this->expectExceptionCode(500);

        // Act, Assert
        $this->sut->setUpdatedAt(new DateTime('2020-01-01'));
    }
}