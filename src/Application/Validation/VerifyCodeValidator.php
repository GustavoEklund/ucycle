<?php

namespace Application\Validation;

use RangeException;

/**
 * Class VerifyCodeValidator
 * @package Application\Validation
 */
class VerifyCodeValidator
{
    public function validate(int $value): int
    {
        if ($value < 100000 || $value > 999999) {
            throw new RangeException('O código de verificação deve ser um número inteiro entre 100000 e 999999.', 500);
        }

        return $value;
    }
}
