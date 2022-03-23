<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListCategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_list_categories')]
    public function index(): Response
    {
        return $this->render('list_categories/index.html.twig', [
            'controller_name' => 'ListCategoriesController',
        ]);
    }
}
