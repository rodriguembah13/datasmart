<?php

namespace App\Form;

use App\Entity\ImplObjectif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImplObjectifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('offre')
            ->add('delai', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
            ])
            //->add('implementation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImplObjectif::class,
        ]);
    }
}
