<?php

namespace Domain\UseCase\AuthenticationToken;

use Doctrine\ORM\ORMException;
use Domain\Entity\AuthenticationToken;
use Domain\Repository\AuthenticationTokenRepository;
use Domain\UseCase\UseCase;

/**
 * Class DeleteAuthenticationToken
 * @package Domain\UseCase\AuthenticationToken
 */
class DeleteAuthenticationToken extends UseCase
{
    /**
     * @param AuthenticationToken $auth_token
     * @throws ORMException
     */
    public function execute(AuthenticationToken $auth_token): void
    {
        /** @var AuthenticationTokenRepository $auth_token_repository */
        $auth_token_repository = $this
            ->getEntityManager()
            ->getRepository(AuthenticationToken::class);

        $auth_token_repository->remove($auth_token);
    }
}