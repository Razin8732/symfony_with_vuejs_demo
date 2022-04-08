<?php

namespace App\Controller;

use Safe\Exceptions\JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use function Safe\json_encode;

class HomeController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/{vueRouting}', requirements: ["vueRouting" => "^(?!api|_(profiler|wdt)).*"], name: 'app_home')]
    public function index(): Response
    {

        $user = $this->getUser();
        $data = null;
        if (!empty($user)) {
            $userClone = clone $user;
            $userClone->setPassword('');
            $data = $this->serializer->serialize($userClone, JsonEncoder::FORMAT);
        }
        
        return $this->render('base.html.twig', [
            'isAuthenticated' => json_encode(!empty($user)),
            'user' => $data ?? json_encode($data),
        ]);
    }
}
