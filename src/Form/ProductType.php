<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product_title', TextType::class, [
                'label' => 'Titre du produit',
                'attr' => [
                    'class' => 'input-custom mt-2',
                    'placeholder' => 'Titre'
                ],
            ])
            ->add('product_price', TextType::class, [
                'label' => 'Prix de produit',
                'attr' => [
                    'class' => 'input-custom mt-2',
                    'placeholder' => 'Prix'
                ],
            ])
            ->add('product_description', TextareaType::class, [
                'label' => 'Description du produit',
                'attr' => [
                    'class' => 'input-custom mt-2',
                    'placeholder' => 'Description'
                ],
            ])
            ->add('product_images', FileType::class, [
                'label' => 'Image du produit',
                'mapped' => false,
                'attr' => [
                    'class' => 'input-custom mt-2',
                ],
            ])
            ->add('product_category', EntityType::class, [
                    'label' => 'Catégorie du produit',
                    'class' => Category::class,
                    'choice_label' => 'category_name',
                    'attr' => [
                        'class' => 'input-custom mt-2',
                    ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
