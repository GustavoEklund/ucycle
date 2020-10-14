<?php

namespace Application\Validation;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailValidatorTest
 * @package Application\Validation
 */
class EmailValidatorTest extends TestCase
{
    private EmailValidator $sut;

    public function setUp(): void
    {
        $this->sut = new EmailValidator;
    }

    public function test_assert_invalid_email_throws_exception(): void
    {
        // Arrange
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email inválido.');
        $this->expectExceptionCode(400);

        // Act, Assert
        $this->sut->validate('invalid_email@mail');
    }

    public function test_assert_validator_returns_email_if_valid(): void
    {
        // Arrange
        $email = 'any_email@any.mail.com';

        // Act, Assert
        self::assertEquals($email, $this->sut->validate($email));
    }
}