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
        'This is the first option' => 'choice1',
        'This is choice 2' => 'choice2',
        'This is choice 3' => 'choice3',
        'Honey' => 'choice4',
        'Banana' => 'choice5',
        'Apples' => 'choice6',
        'Oranges' => 'choice7',
        'Mustard' => 'choice8',
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
