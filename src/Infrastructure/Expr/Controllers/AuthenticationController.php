<?php

namespace Infrastructure\Expr\Controllers;

use Application\Authentication;
use Application\Email\Email;
use Application\Factory\TokenFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Domain\Entity\AuthenticationToken;
use Domain\Entity\User;
use Domain\UseCase\User\CreateUser;
use Domain\UseCase\User\FindUserBy;
use Domain\UseCase\User\UpdateUser;
use Exception;
use Expr\Controller;
use Expr\Request;
use Expr\Response;
use JsonException;
use RuntimeException;

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

        $first_name = explode(' ', $user->getFullName())[0];
        $email_body = file_get_contents(__DIR__.'/../../../Application/Email/Templates/email-confirm.html');

        if (!$email_body) {
            throw new RuntimeException('Erro ao enviar o email de confirmação.');
        }

        $email_body = str_replace(
            ['{{first_name}}', '{{verify_code}}'],
            [$first_name, $user->getVerifyCode()],
            $email_body
        );

        $email = (new Email)
            ->setSubject('Confirmação de Email')
            ->setBody($email_body)
            ->setRecipientName($user->getFullName())
            ->setRecipientEmail($user->getEmail());

        $email->send();

        $entity_manager->flush();

        return $response->status(200)->send('Usuário criado com sucesso.');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param EntityManager $entity_manager
     * @return string
     * @throws Exception
     */
    public function login(Request $request, Response $response, EntityManager $entity_manager): string
    {
        $body = $request->getBody();

        $user_list = (new FindUserBy($entity_manager))
            ->execute(['email' => @$body['email']], [], 1);

        if (empty($user_list) || !$user_list[0]->isPasswordValid(@$body['password'])) {
            throw new RuntimeException('Usuário ou senha incorretos.', 404);
        }

        $auth_token = (new AuthenticationToken)
            ->setSub($user_list[0])
            ->setCreatedBy($user_list[0])
            ->setUpdatedBy($user_list[0]);

        $token = TokenFactory::create($auth_token, $entity_manager);

        return $response->status(201)->send($token);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param EntityManager $entity_manager
     * @param AuthenticationToken $auth_token
     * @return string
     * @throws JsonException|ORMException|Exception
     */
    public function verify(
        Request $request,
        Response $response,
        EntityManager $entity_manager,
        AuthenticationToken $auth_token
    ): string
    {
        $params = $request->getParams();

        $user = (new FindUserBy($entity_manager))
            ->execute(['uuid' => $auth_token->getSub()->getUuid()->toString()]);

        if (empty($user)) {
            throw new RuntimeException('Erro ao conectar-se com o servidor.', 500);
        }

        $verify_code = (int) @$params['verify_code'];

        if ($user[0]->getVerifyCode() !== $verify_code) {
            throw new RuntimeException('Código de verificação inválido.', 401);
        }

        (new UpdateUser($entity_manager))
            ->execute($user[0]->setVerified(true));

        $response->append('refresh_token', TokenFactory::create($auth_token, $entity_manager));

        return $response->status(200)->send('Email confirmado com sucesso.');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param EntityManager $entity_manager
     * @return AuthenticationToken
     */
    public function authorize(Request $request, Response $response, EntityManager $entity_manager): AuthenticationToken
    {
        $headers = apache_request_headers();

        if (!$headers || empty($headers)) {
            throw new RuntimeException('Os cabeçalhos de requisição não estão presentes.', 403);
        }

        if (empty($headers['Authorization'])) {
            throw new RuntimeException('Usuário não autenticado.', 401);
        }

        return (new Authentication(new AuthenticationToken))
            ->validateToken($headers['Authorization'], $entity_manager);
    }
}