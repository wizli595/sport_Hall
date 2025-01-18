<?php

namespace App\Form;

use App\Entity\Abonne;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('fname')
            ->add('lname')
            ->add('tele')
            ->add('datetime', null, [
                'widget' => 'single_text',
            ])
            ->add('activeSub')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // Show email in dropdown
                'placeholder' => 'Choose a user',
                'required' => true,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}