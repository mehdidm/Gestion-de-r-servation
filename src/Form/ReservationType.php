<?php

namespace App\Form;
use App\Entity\Client;
use App\Entity\Service;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_r')
            ->add('etat')
            ->add('id_cli',EntityType::class,['class' => Client::class,
                 'choice_label' => 'nom',
                'label' => 'Client'])
            ->add('id_service',EntityType::class,['class' => Service::class,
                'choice_label' => 'libelle',
               'label' => 'Service'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
