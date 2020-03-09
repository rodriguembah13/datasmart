<?php

namespace App\Form;

use App\Entity\Implementation;
use App\Entity\ImplPlanning;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImplPlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('implementation', EntityType::class, [
                'class' => Implementation::class,
                'placeholder' => 'Select You State',
                'multiple' => false,
                'attr' => ['class' => 'selectpicker', 'data-size' => 10, 'data-live-search' => true],
            ])
            ->add('datebegin', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
            ])
           // ->add('status')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImplPlanning::class,
        ]);
    }
}
