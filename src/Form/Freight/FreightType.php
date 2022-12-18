<?php

namespace App\Form\Freight;

use App\Entity\Car\Car;
use App\Entity\Driver;
use App\Entity\Freight\Freight;
use App\Entity\Freight\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FreightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate')
            ->add('destinationDate')
            ->add('startLocation', EntityType::class, [
                'label' => 'startLocation',
                'class' => Location::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true
            ])
            ->add('destination', EntityType::class, [
                'label' => 'destination',
                'class' => Location::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true
            ])
            ->add('distance')
            ->add('driver', EntityType::class, [
                'label' => 'driver',
                'class' => Driver::class,
                'choice_label' => 'user.fullname',
                'multiple' => false,
                'required' => true
            ])
            ->add('car', EntityType::class, [
                'label' => 'car',
                'class' => Car::class,
                'choice_label' => 'licensePlate',
                'multiple' => false,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Freight::class,
        ]);
    }
}
