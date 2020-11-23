<?php

namespace Tests\Domain\Entity;

use Domain\Entity\User;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RangeException;

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

    public function test_set_password_size_less_than_6_throw_error(): void
    {
        // Assert
        $this->expectException(RangeException::class);

        // Arrange, Act
        $this->sut->setPassword('12345');
    } // test_set_password_size_less_than_6_throw_error

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

    public function test_assert_verified_starts_with_false(): void
    {
        self::assertFalse($this->sut->getVerified());
    }

    public function test_can_set_verified(): void
    {
        // Arrange, Act
        $this->sut->setVerified(true);

        // Assert
        self::assertTrue($this->sut->getVerified());
    }

    /** @throws Exception */
    public function test_assert_verify_code_starts_with_random_number(): void
    {
        // Arrange, Act
        $user1 = new User;
        $user2 = new User;

        // Assert
        self::assertNotEquals($user1->getVerifyCode(), $user2->getVerifyCode());
    }

    /** @throws Exception */
    public function test_assert_can_set_verify_code(): void
    {
        // Arrange
        $random = random_int(100000, 999999);

        // Act
        $this->sut->setVerifyCode($random);

        // Assert
        self::assertEquals($random, $this->sut->getVerifyCode());
    }

    public function test_assert_set_invalid_verify_code_throws_exception(): void
    {
        // Arrange
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('O código de verificação deve ser um número inteiro entre 100000 e 999999.');
        $this->expectExceptionCode(500);

        // Act, Assert
        $this->sut->setVerifyCode(1000000);
    }
}
