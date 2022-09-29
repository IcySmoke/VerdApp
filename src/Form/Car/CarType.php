<?php

namespace App\Form\Car;

use App\Entity\Car\Car;
use App\Entity\Car\Fuel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand')
            ->add('model')
            ->add('horsePower')
            ->add('licensePlate')
            ->add('year')
            ->add('km')
            ->add('image')
            ->add('averageConsumption')
            ->add('fuelType', EntityType::class, [
                'label' => 'Fuel type',
                'class' => Fuel::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
