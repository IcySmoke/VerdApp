<?php

namespace App\Form\Car;

use App\Entity\Car\Tire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand')
            ->add('type')
            ->add('width')
            ->add('aspectRatio')
            ->add('rim')
            ->add('loadIndex')
            ->add('speedRating')
            ->add('dot')
            ->add('distance')
            ->add('count',null, [
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tire::class,
        ]);
    }
}
