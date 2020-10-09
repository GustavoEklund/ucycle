<?php

namespace Application\Validation;

use DateTime;
use PHPUnit\Framework\TestCase;
use RangeException;

/**
 * Class DateTimeValidatorTest
 * @package Application\Validation[
 */
class DateTimeValidatorTest extends TestCase
{
    public function test_assert_date_time_before_now_throw_exception(): void
    {
        // Arrange
        $this->expectException(RangeException::class);
        $this->expectExceptionMessage('The date time can\'t be before now.');
        $this->expectExceptionCode(500);

        // Act, Assert
        (new DateTimeValidator)->validate(new DateTime('2020-01-01'));
    }
}