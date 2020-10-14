<?php

namespace Tests\Domain\Entity;

use Domain\Entity\User;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 * @package Tests\Domain\Entity
 */
class UserTest extends TestCase
{
    protected User $sut;

    public function setUp(): void
    {
        $this->sut = new User;
    }

    public function test_assert_get_null_full_name_when_not_defined(): void
    {
        self::assertNull($this->sut->getFullName());
    }

    public function test_can_set_full_name(): void
    {
        // Arrange
        $full_name = 'AnyFullName';

        // Act
        $this->sut->setFullName($full_name);

        // Assert
        self::assertEquals($full_name, $this->sut->getFullName());
    }

    public function test_assert_set_invalid_full_name_throws_exception(): void
    {
        // Arrange
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O nome completo deve ter pelo menos 2 nomes.');
        $this->expectExceptionCode(400);

        // Act, Assert
        $this->sut->setFullName('InvalidFullName');
    }

    public function test_assert_get_null_email_when_not_defined(): void
    {
        self::assertNull($this->sut->getEmail());
    }
}