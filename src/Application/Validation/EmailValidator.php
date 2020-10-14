<?php

namespace Application\Validation;

use InvalidArgumentException;
use Respect\Validation\Validator;

/**
 * Class EmailValidator
 * @package Application\Validation
 */
class EmailValidator
{
    public function validate(string $email): string
    {
        if (!Validator::email()->validate($email)) {
            throw new InvalidArgumentException('Email inválido.', 400);
        }

        return $email;
    }
}