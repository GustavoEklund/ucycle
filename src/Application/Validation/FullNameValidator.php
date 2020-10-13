<?php

namespace Application\Validation;

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

        foreach ($name_array as $value) {
            if (strlen($value) < 2) {
                throw new RangeException('O nome ou sobrenome deve ter pelo menos 2 caracteres.', 400);
            } // if
        } // foreach

        return $full_name;
    }
}