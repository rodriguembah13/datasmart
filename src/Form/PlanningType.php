<?php

namespace App\Form;

use App\Entity\Planning;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateBegin', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
            ])
            ->add('status')
            ->add('stepStrategy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
