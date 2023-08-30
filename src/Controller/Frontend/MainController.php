<?php

namespace App\Controller\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(): Response
    {
        $data = ['Pierre', 'Paul', 'Jacques'];

        return $this->render('main/index.html.twig', [
            'donnees' => $data,
            'name' => 'Mike',
        ]);
    }
}
