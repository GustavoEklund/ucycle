<?php

namespace Tests\Application\Validation;

use Application\Validation\VerifyCodeValidator;
use PHPUnit\Framework\TestCase;
use RangeException;

/**
 * Class VerifyCodeValidatorTest
 * @package Tests\Application\Validation
 */
class VerifyCodeValidatorTest extends TestCase
{
    private VerifyCodeValidator $sut;

    public function setUp(): void
    {
        $this->sut = new VerifyCodeValidator;
    }

    public function test_assert_number_greater_than_999999_throws_exception(): void
    {
        // Assert
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('O código de verificação deve ser um número inteiro entre 100000 e 999999.');
        $this->expectExceptionCode(500);

        // Arrange, Act
        $this->sut->validate(1000000);
    }

    public function test_assert_number_less_than_100000_throws_exception(): void
    {
        // Assert
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('O código de verificação deve ser um número inteiro entre 100000 e 999999.');
        $this->expectExceptionCode(500);

        // Arrange, Act
        $this->sut->validate(99999);
    }

    public function test_assert_validator_returns_verify_code_if_valid(): void
    {
        // Arrange
        $verify_code = 500000;

        // Act, Assert
        self::assertEquals($verify_code, $this->sut->validate($verify_code));
    }
}
