<?php

namespace Application\Validation;

use DateTime;
use RangeException;

/**
 * Class DateTimeValidator
 * @package Application\Validation
 */
class DateTimeValidator
{
    public function validate(DateTime $date_time): void
    {
        if ($date_time->getTimestamp() < (new DateTime('now'))->getTimestamp()) {
            throw new RangeException('The date time can\'t be before now.', 500);
        }
    }
}