<?php

namespace Domain\UseCase\User;

use Domain\Entity\User;
use Domain\UseCase\UseCase;

/**
 * Class FindUserBy
 * @package Domain\UseCase\User
 */
class FindUserBy extends UseCase
{
    /**
     * @param array $criteria
     * @param array $order_by
     * @param int|null $limit
     * @param int|null $offset
     * @return User[]
     */
    public function execute(array $criteria, array $order_by = [], int $limit = null, int $offset = null): array
    {
        $user_repository = $this
            ->getEntityManager()
            ->getRepository(User::class);

        $user_list = $user_repository->findBy($criteria, $order_by, $limit, $offset);

        if (!is_array($user_list) || empty($user_list)) {
            return [];
        }

        return $user_list;
    }
}
