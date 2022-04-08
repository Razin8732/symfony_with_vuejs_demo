<?php

namespace App\Controller;

use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class SecurityController extends AbstractController
{

    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * This is to logg in a user.
     * First need to add json_login attribute in the security.yaml file.
     * Then add the following code in the SecurityController.php file.
     * Login works from UserInterface and UserProvider.
     */
    #[Route('/security/login', name: 'login')]
    public function loginAction(): JsonResponse
    {
        $user = $this->getUser();
        $userClone = clone $user;
        $userClone->setPassword('');
        $data = $this->serializer->serialize($userClone, JsonEncoder::FORMAT);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * Logout will be handle by config/packages/security.yaml firewalls->main->logout attribute
     * This method is created to implement logout route as describe in the documentation
     * https://symfony.com/doc/current/security.html#logging-out
     */
    #[Route('/security/logout', name: 'logout')]
    public function logoutAction(): void
    {
        throw new RuntimeException('This Shold not be reached!', 403);
    }
}
