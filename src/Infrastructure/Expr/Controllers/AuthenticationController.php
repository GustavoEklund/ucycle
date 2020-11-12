<?php

namespace Infrastructure\Expr\Controllers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\User;
use Domain\UseCase\User\CreateUser;
use Expr\Controller;
use Expr\Request;
use Expr\Response;
use JsonException;

/**
 * Class AuthenticationController
 * @package Infrastructure\Expr\Controllers
 */
class AuthenticationController extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @param EntityManager $entity_manager
     * @return string
     * @throws ORMException|JsonException
     */
    public function register(Request $request, Response $response, EntityManager $entity_manager): string
    {
        $body = $request->getBody();

        $password = (string) @$body['password'];

        $user = new User;
        $user
            ->setFullName((string) @$body['full_name'])
            ->setEmail((string) @$body['email'])
            ->setPassword($password)
            ->setCreatedBy($user)
            ->setUpdatedBy($user);

        (new CreateUser($entity_manager))->execute($user, $password);

        $entity_manager->flush();

        return $response->status(200)->send('Usuário criado com sucesso.');
    }
}