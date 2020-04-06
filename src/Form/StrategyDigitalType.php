<?php

namespace App\Form;

use App\Entity\StrategyDigital;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StrategyDigitalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $choices = [
        'Offre Produit' => 'produit',
        'Offre Service' => 'service',
    ];
        $choicesSub = [
            'Formation' => 'formation',
            'Coaching' => 'coaching',
            'Consulting' => 'consulting',
            'Prestasion Service' => 'prestation',
        ];
        $choicesSubProduit = [
        'Produit Unique' => 'Produit Unique',
            'Collection Produit' => 'Produit Collection',
    ];
        $builder
            ->add('name')
            ->add('typeOffre', ChoiceType::class, [
                'choices' => $choices,
                'placeholder' => 'Choisir un type offre',
                'required' => true,
                'attr' => ['class' => 'selectpicker', 'data-size' => 5, 'data-live-search' => true],
            ])
            ->add('subTypeProduit', ChoiceType::class, [
                'choices' => $choicesSubProduit,
                'placeholder' => 'Choisir un type produit',
                'required' => false,
                'attr' => ['class' => 'selectpicker', 'data-size' => 5, 'data-live-search' => true],
            ])
            ->add('subTypeOffre', ChoiceType::class, [
                'choices' => $choicesSub,
                'placeholder' => 'Choisir un type service',
                'multiple' => true,
                'attr' => ['class' => 'selectpicker', 'data-size' => 5, 'data-live-search' => true],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StrategyDigital::class,
        ]);
    }
}
