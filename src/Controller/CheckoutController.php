<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout/{id}', name: 'app_checkout')]
    public function index(Product $product, ProductRepository $productRepository, OrderRepository $orderRepository): Response
    {
        $order = new Order();
        $order->addOrderProduct($product);

        $orderRepository->add($order);
        $productRepository->remove($product);

        $this->addFlash(
            'success',
            'La commande a bien été effectuée !'
        );

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
