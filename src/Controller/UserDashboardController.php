<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Shop;
use App\Entity\User;
use App\Form\ProductType;
use App\Form\ShopType;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop-dashboard', name: 'app_user_dashboard_')]
class UserDashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ShopRepository $shopRepository): Response
    {
        return $this->render('user_dashboard/index.html.twig', [
            'controller_name' => 'UserDashboardController',
        ]);
    }

    // ------------------------------
    // ----- PRODUCT MANAGEMENT -----
    // ------------------------------

    #[Route('/products', name: 'product_index', methods: ['GET'])]
    public function productIndex(ProductRepository $productRepository): Response
    {
        return $this->render('user_dashboard/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/product/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function productNew(Request $request, ProductRepository $productRepository): Response
    {
        /** @var $user User */
        $user = $this->getUser();

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['product_images']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/product_image';

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $product->setProductImages($newFilename);
            }

            $product->setProductAuthor($user);
            $product->setProductShop($user->getShop());
            $productRepository->add($product);
            return $this->redirectToRoute('app_user_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_dashboard/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/product/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function productEdit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product);
            return $this->redirectToRoute('app_user_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_dashboard/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/product/{id}', name: 'product_delete', methods: ['POST'])]
    public function productDelete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product);
        }

        return $this->redirectToRoute('app_user_dashboard', [], Response::HTTP_SEE_OTHER);
    }

    // ---------------------------
    // ----- SHOP MANAGEMENT -----
    // ---------------------------

    #[Route('/{id}/edit', name: 'shop_edit', methods: ['GET', 'POST'])]
    public function ShopEdit(Request $request, Shop $shop, ShopRepository $shopRepository): Response
    {
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shopRepository->add($shop);
            return $this->redirectToRoute('app_shop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_dashboard/shop/edit.html.twig', [
            'shop' => $shop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'shop_delete', methods: ['POST'])]
    public function shopDelete(Request $request, Shop $shop, ShopRepository $shopRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shop->getId(), $request->request->get('_token'))) {
            $shopRepository->remove($shop);
        }

        return $this->redirectToRoute('app_shop_index', [], Response::HTTP_SEE_OTHER);
    }
}
