<?php

namespace App\Form;

use App\Entity\Catalogue;
use App\Entity\Ressources;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatalogueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('fournisseur')
            ->add('dateAjoutCat', null, [
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->add('ressources', EntityType::class, [
                'class' => Ressources::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Catalogue::class,
        ]);
    }
}
