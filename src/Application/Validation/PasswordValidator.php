<?php

namespace Application\Validation;

use RangeException;

/**
 * Class PasswordValidator
 * @package Application\Validation
 */
class PasswordValidator
{
    public function validate(string $password): string
    {
        if (strlen($password) < 6) {
            throw new RangeException('A senha deve ter pelo menos 6 caracteres.', 400);
        }

        return '';
    }
}