<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user,
        ]);
    }

    #[Route('account/edit', name: 'app_edit_account')]
    public function editAccount(): Response
    {
        $user = $this->getUser();

        return $this->render('account/edit-account.html.twig', [
            'controller_name' => 'EditAccountController',
            'user' => $user,
        ]);
    }



}
