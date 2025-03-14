<?php

namespace App\Form;

use App\Entity\Ressources;
use App\Entity\Catalogue;
use App\Enum\RessourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RessourcesType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', EnumType::class, [
            'class' => RessourceType::class,
            'choice_label' => fn (RessourceType $type) => $type->label(),
            'choice_value' => fn (?RessourceType $type) => $type?->value,
            'placeholder' => 'Choisissez un type de ressource',
        ])
            ->add('quantiteDisponible', IntegerType::class)

            ->add('dateAjout', null, [
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])

            ->add('catalogues', EntityType::class, [
                'class' => Catalogue::class,
                'choice_label' => 'description', // ou 'id' ou tout autre champ
                'multiple' => true, // Permet de sélectionner plusieurs catalogues
                'expanded' => true, // Affiche une liste de cases à cocher
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressources::class,
        ]);
    }
}