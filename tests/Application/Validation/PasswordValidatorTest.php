<?php

namespace Application\Validation;

use PHPUnit\Framework\TestCase;
use RangeException;

/**
 * Class PasswordValidatorTest
 * @package Application\Validation
 */
class PasswordValidatorTest extends TestCase
{
    private PasswordValidator $sut;

    public function setUp(): void
    {
        $this->sut = new PasswordValidator;
    }

    public function test_assert_password_with_less_than_6_characters_throws_exception(): void
    {
        // Arrange
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('A senha deve ter pelo menos 6 caracteres.');
        $this->expectExceptionCode(400);

        // Act, Assert
        $this->sut->validate('12345');
    }
}