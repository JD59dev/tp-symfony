<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price', RangeType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 999999,
                    'class' => 'p-0', // Bootstrap class added on the input
                ],
            ])
            ->add('creation_date')
            ->add('color_list', ChoiceType::class, [
                'label' => 'Choisissez une couleur',
                'choices' => [
                    'Rouge' => 'Rouge',
                    'Bleu' => 'Bleu',
                    'Vert' => 'Vert'
                ],
            ])
            ->add('image', FileType::class, [
                // We deactivate the BDD link for the image because Symfony can't display it
                'mapped' => false,
            ])

            ->add('promotion', ChoiceType::class, [
                'label' => 'Promotion ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('type', null, [
                'choice_label' => 'name', // Displaying the value the objects' name property
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
