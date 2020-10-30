<?php

namespace Domain\Repository\Interfaces;

use Domain\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package Domain\Repository\Interfaces
 */
interface UserRepositoryInterface
{
    public function create(User $user): void;
}