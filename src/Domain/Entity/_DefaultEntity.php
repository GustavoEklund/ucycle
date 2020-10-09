<?php

namespace Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class _DefaultEntity
 * @package Domain\Entity
 */
class _DefaultEntity
{
    public function getUuid(): UuidInterface
    {
        return Uuid::uuid4();
    }
}