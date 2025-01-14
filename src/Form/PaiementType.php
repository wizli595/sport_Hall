<?php

namespace App\Form;

use App\Entity\Abonne;
use App\Entity\Paiement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('payDate', null, [
                'widget' => 'single_text',
            ])
            ->add('modePay')
            ->add('abonne', EntityType::class, [
                'class' => Abonne::class,
                'choice_label' => 'name',
                'multiple' => false,
                'label' => 'Abonné',
                'placeholder' => 'Choisir un abonné',
                'required' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}