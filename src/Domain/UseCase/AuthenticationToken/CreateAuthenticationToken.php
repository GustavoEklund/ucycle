<?php

namespace Domain\UseCase\AuthenticationToken;

use Doctrine\ORM\ORMException;
use Domain\Entity\AuthenticationToken;
use Domain\Exception\RequiredValueException;
use Domain\Repository\AuthenticationTokenRepository;
use Domain\UseCase\UseCase;

/**
 * Class CreateAuthenticationToken
 * @package Domain\UseCase\AuthenticationToken
 */
class CreateAuthenticationToken extends UseCase
{
    /**
     * @param AuthenticationToken $auth_token
     * @throws ORMException
     */
    public function execute(AuthenticationToken $auth_token): void
    {
        if ($auth_token->getSub() === null) {
            throw new RequiredValueException('Sujeito', 500);
        }

        if ($auth_token->getCreatedBy() === null) {
            throw new RequiredValueException('Criado por', 500);
        }

        if ($auth_token->getUpdatedBy() === null) {
            throw new RequiredValueException('Atualizado por', 500);
        }

        /** @var AuthenticationTokenRepository $auth_token_repository */
        $auth_token_repository = $this
            ->getEntityManager()
            ->getRepository(AuthenticationToken::class);

        $auth_token_repository->create($auth_token);
    }
}