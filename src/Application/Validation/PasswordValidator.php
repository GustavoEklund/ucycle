<?php

namespace Application\Validation;

use RangeException;
use RuntimeException;

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

        $password_hash = $this->parse($password);

        if ($password_hash === false || !password_verify($password, $password_hash)) {
            // Exception not testable
            throw new RuntimeException('Erro ao processar a senha.');
        } // if

        return $password_hash;
    }

    public function parse(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}