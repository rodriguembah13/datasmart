<?php

namespace App\Form;

use App\Entity\CibleAvatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CibleAvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {$options = [
        'Combien gagne-t-il ou potentiellement quelle plage de revenu a-t-il ?' => 'Combien gagne-t-il ou potentiellement quelle plage de revenu a-t-il ?',
        'Quels sont ses problèmes les plus préoccupants ainsi que les solutions potentielles existantes?' => 'Quels sont ses problèmes les plus préoccupants ainsi que les solutions potentielles existantes?',
        'Quel âge à t – il ?' => 'Quel âge à t – il ?',
        'Quel est son statut familial ?' => 'Quel est son statut familial ?',
        'Est-il un homme, une femme, autres ?' => 'Est-il un homme, une femme, autres ?',
        'Où le trouver, géographiquement (Quartier, ville, pays) ?' => 'Où le trouver, géographiquement (Quartier, ville, pays) ?',
        'Quelles sont ses valeurs ?' => 'Quelles sont ses valeurs ?',
        'Quels sont ses buts ?' => 'Quels sont ses buts ?',
        'Quelles sont ses priorités ?' => 'Quelles sont ses priorités ?',
        'Quelles sont les frustrations qu’il souhaite eviter ?' => 'Quelles sont les frustrations qu’il souhaite eviter',
        'Quels sont les obstacles qui l’empechent d’atteindre ses objectifs ?' => 'Quels sont les obstacles qui l’empechent d’atteindre ses objectifs ?',
        'Autres' => 'autres',
    ];
        $builder
            ->add('question', ChoiceType::class, [
                'choices' => $options,
                'multiple' => false,
                'attr' => ['class' => 'selectpicker', 'data-size' => 5, 'data-live-search' => true],
            ])
            ->add('answer', TextareaType::class, [
                'required' => false,
                'label' => 'Answer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CibleAvatar::class,
        ]);
    }
}
