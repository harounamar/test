<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Production;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateProd', null, [
                'widget' => 'single_text',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Lait' => Production::TYPE_LAIT,  
                    'Oeuf' => Production::TYPE_OEUF, 
                    'Viande' => Production::TYPE_VIANDE, 
                ],
                'expanded' => false,  
                'multiple' => false, 
            ])
            ->add('quantiteProd')
            ->add('qualiteProd')
            ->add('animal', EntityType::class, [
                'class' => Animal::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Production::class,
        ]);
    }
}
