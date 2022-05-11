<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(ProductRepository $repository, ShopRepository $shopRepository, Request $request): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $products = $repository->findSearch($data);
        $shops = $shopRepository->findSearchShop($data);
        return $this->render('search/index.html.twig', [
            'products' => $products,
            'shops' => $shops,
            'form' => $form->createView()
        ]);
    }
}
