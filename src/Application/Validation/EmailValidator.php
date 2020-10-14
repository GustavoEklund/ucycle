<?php

namespace Application\Validation;

use InvalidArgumentException;

/**
 * Class EmailValidator
 * @package Application\Validation
 */
class EmailValidator
{
    public function validate(string $email): string
    {
        throw new InvalidArgumentException('Email inválido.', 400);
    }
}