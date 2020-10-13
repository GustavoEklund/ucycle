<?php

namespace Tests\Application\Validation;

use Application\Validation\FullNameValidator;
use PHPUnit\Framework\TestCase;
use RangeException;

/**
 * Class FullNameValidatorTest
 * @package Tests\Application\Validation
 */
class FullNameValidatorTest extends TestCase
{
    protected FullNameValidator $sut;

    public function setUp(): void
    {
        $this->sut = new FullNameValidator();
    }

    public function nameWithLessThanTwoCharacters(): array
    {
        return [
            ['A Full Name'],
            ['Any F Name'],
            ['ANY FULL N'],
        ];
    }

    /**
     * @dataProvider nameWithLessThanTwoCharacters
     * @param string $full_name
     */
    public function test_assert_name_with_less_than_2_chars_throw_exception(string $full_name): void
    {
        // Arrange
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('O nome ou sobrenome deve ter pelo menos 2 caracteres.');
        $this->expectExceptionCode(400);

        // Act, Assert
        $this->sut->validate($full_name);
    }
}