<?php

namespace App\Form\Car;

use App\Entity\Car\Tire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TireToCar extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tire::class,
        ]);
    }
}