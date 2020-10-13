<?php

namespace Application\Validation;

use InvalidArgumentException;
use RangeException;

/**
 * Class FullNameValidator
 * @package Application\Validation
 */
class FullNameValidator
{
    public function validate(string $full_name): string
    {
        $name_array = explode(' ', $full_name);

        if (count($name_array) < 2) {
            throw new InvalidArgumentException('O nome completo deve ter pelo menos 2 nomes.', 400);
        } // if


        foreach ($name_array as $value) {
            if (strlen($value) < 2) {
                throw new RangeException('O nome ou sobrenome deve ter pelo menos 2 caracteres.', 400);
            } // if
        } // foreach

        return $this->parseFullName($full_name);
    }

    public function parseFullName(string $full_name): string
    {
        return ucwords(strtolower($full_name));
    }
}