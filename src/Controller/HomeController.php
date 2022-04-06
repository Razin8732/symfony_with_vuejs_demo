<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/{vueRouting}', requirements: ["vueRouting" => "^(?!api|_(profiler|wdt)).*"], name: 'app_home')]
    public function index(): Response
    {

        $words = [
            'sky', 'cloud', 'wood', 'rock', 'forest',
            'mountain', 'breeze'
        ];
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
            'words' => $words
        ]);
    }
}
