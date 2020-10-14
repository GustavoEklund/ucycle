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
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email inválido.');
        $this->expectExceptionCode(400);

        $this->sut->validate('invalid_email@mail');
    }
}