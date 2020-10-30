<?php


namespace Domain\Exception;

use Throwable;
use RuntimeException;

/**
 * Class RequiredValueException
 * @package Domain\Exception
 */
class RequiredValueException extends RuntimeException
{
    public function __construct(string $message = '', int $code = 400, Throwable $previous = null)
    {
        $custom_message = "{$message} não informado.";
        parent::__construct($custom_message, $code, $previous);
    }
}