<?php

namespace App\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', name: 'admin.user')]

class ListeUsersController extends AbstractController
{
    
    public function __construct(
        private readonly UserRepository $repo
    ){

    }
    
    #[Route('', name: '.index' ,methods: ['GET'])]    
    public function index():Response
    {
        return $this->render('Backend/User/index.html.twig', [
            'users' => $this->repo->findAll() ,
        ]);
    }

    #[Route('/{id}/edit', name: '.update' , methods: ['GET', 'POST'])]

    public function update(?User $user,Request $request): Response|RedirectResponse
    {
        if(!$user instanceof User){

            $this->addFlash('error','user not found');

            return $this->redirectToRoute('admin.user.index');

        }
       
        //TODO:   create form user with condition and return view

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->repo->save($user,true);

            $this->addFlash('success','GG poulet');
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('Backend/User/edit.html.twig',[
            'form' => $form,

        ]);
    }

    #[Route('/{id}/delete',name:'.delete',methods:['POST'])]
    public function delete(?User $user, Request $request): RedirectResponse
    {
        if (!$user instanceof User) {
            $this->addFlash('error',  'user not found');

            return $this->redirectToRoute('admin.user.index');
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {
            $this->repo->remove($user, true);

            $this->addFlash('success', 'user deleted successfully');

            return $this->redirectToRoute('admin.user.index');
        }

        $this->addFlash('error', 'Token invalide');

        return $this->redirectToRoute('admin.user.index');
    }


    }

    