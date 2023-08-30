<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repo
    ) {
    }

    #[Route('/register', name: 'app.user.register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        // On instancie User
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $hasher->hashPassword($user, $form->get('password')->getData())
            );

            $this->repo->save($user, true);

            $this->addFlash('success', 'Vous être bien inscrit à notre application');

            return $this->redirectToRoute('app.login');
        }

        return $this->render('Frontend/User/register.html.twig', [
            'form' => $form,
        ]);
    }

    
}
