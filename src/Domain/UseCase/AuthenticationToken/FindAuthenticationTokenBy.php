<?php

namespace Domain\UseCase\AuthenticationToken;

use Domain\Entity\AuthenticationToken;
use Domain\UseCase\UseCase;

/**
 * Class FindAuthenticationTokenBy
 * @package Domain\UseCase\AuthenticationToken
 */
class FindAuthenticationTokenBy extends UseCase
{
    /**
     * @param array $criteria
     * @param array $order_by
     * @param int|null $limit
     * @param int|null $offset
     * @return AuthenticationToken[]
     */
    public function execute(array $criteria, array $order_by = [], int $limit = null, int $offset = null): array
    {
        $authentication_token_repository = $this
            ->getEntityManager()
            ->getRepository(AuthenticationToken::class);

        $authentication_token_list = $authentication_token_repository
            ->findBy($criteria, $order_by, $limit, $offset);

        if (!is_array($authentication_token_list) || empty($authentication_token_list)) {
            return [];
        }

        return $authentication_token_list;
    }
}