<?php

namespace Domain\Repository\Interfaces;

use Domain\Entity\AuthenticationToken;

/**
 * Interface AuthenticationTokenRepositoryInterface
 * @package Domain\Repository\Interfaces
 */
interface AuthenticationTokenRepositoryInterface
{
    public function create(AuthenticationToken $user): void;
}