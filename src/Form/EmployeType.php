<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Projet;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Chef de projet' => 'ROLE_ADMIN',
                    'Collaborateur' => 'ROLE_USER',
                ],
                'label' => 'Rôle',
                'multiple' => false,
                'expanded' => false,
                'placeholder' => 'Choisir un rôle',
                'choice_value' => fn ($choice) => $choice,
            ])
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('typeContrat')
            ->add('dateEntree', DateType::class, [
                'widget' => 'single_text',
            ]);
        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
            fn ($rolesArray) => $rolesArray[0] ?? null, // transform (model → view)
            fn ($roleString) => [$roleString]            // reverseTransform (view → model)
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
