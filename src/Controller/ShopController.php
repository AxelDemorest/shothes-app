<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Entity\User;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop')]
class ShopController extends AbstractController
{
    #[Route('/', name: 'app_shop_index', methods: ['GET'])]
    public function index(ShopRepository $shopRepository): Response
    {
        return $this->render('shop/index.html.twig', [
            'shops' => $shopRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_shop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ShopRepository $shopRepository): Response
    {
        /** @var $user User */
        $user = $this->getUser();

        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['shop_icon']->getData();
            $shop->setShopLayout($form->get('shop_layout')->getData());

            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/shop_image';

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();

                $uploadedFile->move(
                    $destination,
                    $newFilename
                );

                $shop->setShopIcon($newFilename);
            }

            $shop->setShopOwner($user);

            $this->addFlash(
                'success',
                'Ta boutique a bien été créée'
            );

            $shopRepository->add($shop);
            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shop/new.html.twig', [
            'shop' => $shop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shop_show', methods: ['GET'])]
    public function show(Shop $shop): Response
    {
        $layout = $shop->getShopLayout();

        if ($layout === 1) {
            $render = 'shop/show.html.twig';
        } else {
            $render = 'shop/show2.html.twig';
        }

        return $this->render($render, [
            'shop' => $shop,
            'products' => $shop->getShopProducts(),
            'layout' => $layout,
        ]);
    }
}
