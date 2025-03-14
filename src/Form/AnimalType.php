<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Sain' => Animal::ETAT_SAIN,  // Utilise la constante ETAT_SAIN
                    'Malade' => Animal::ETAT_MALADE,  // Utilise la constante ETAT_MALADE
                ],
                'expanded' => false,  // Choix dans une liste déroulante
                'multiple' => false,  // Un seul choix possible
            ])
            ->add('dateNaissance', null, [
                'widget' => 'single_text',  // Affiche le champ date comme un champ à date unique
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,  // Associe le formulaire à l'entité Animal
        ]);
    }
}

