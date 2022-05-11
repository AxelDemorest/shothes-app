<?php

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shop_name', TextType::class, [
                'attr' => [
                    'class' => 'input-custom',
                    'placeholder' => 'Nom de la boutique'
                    ],
            ])
            ->add('shop_description', TextareaType::class, [
                'attr' => [
                    'class' => 'input-custom mt-2',
                    'placeholder' => 'description de la boutique'
                ],
            ])
            ->add('shop_icon', FileType::class, [
                'label' => 'Logo de la boutique',
                'mapped' => false,
                'attr' => [
                    'class' => 'input-custom mt-2',
                ],
            ])
            ->add('shop_layout', ChoiceType::class, [
                'label' => 'Choisissez la mise page de la boutique',
                'mapped' => false,
                'attr' => [
                    'class' => 'input-custom mt-2',
                ],
                'choices' => [
                    'Mise en page 1' => 1,
                    'Mise en page 2' => 2,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
