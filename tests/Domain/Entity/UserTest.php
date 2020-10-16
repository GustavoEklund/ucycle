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
        $full_name = 'Any Full Name';

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

    public function test_can_set_email(): void
    {
        // Arrange
        $email = 'any_email@any.mail.com';

        // Act
        $this->sut->setEmail($email);

        // Assert
        self::assertEquals($email, $this->sut->getEmail());
    }

    public function test_assert_set_invalid_email_throws_exception(): void
    {
        // Arrange
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email inválido.');
        $this->expectExceptionCode(400);

        // Act, Assert
        $this->sut->setEmail('invalid@mail');
    }

    public function test_can_set_password(): void
    {
        // Arrange, Act
        $this->sut->setPassword('any_password_123456');

        // Assert
        $this->addToAssertionCount(1);
    }

    public function test_password_validation(): void
    {
        // Arrange, Act
        $this->sut->setPassword('123456');

        // Assert
        self::assertTrue($this->sut->isPasswordValid('123456'));
    }

    public function test_assert_invalid_password_return_false(): void
    {
        // Arrange, Act
        $this->sut->setPassword('123456');

        // Assert
        self::assertFalse($this->sut->isPasswordValid('123454'));
    }
}
