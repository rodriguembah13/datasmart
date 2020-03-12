<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('value')
            //->add('customersCoach')
            ->add('visible', CheckboxType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('isCoach', CheckboxType::class, [
                'required' => false,
                'label' => false,
            ])
            /*->add('registeredAt')
            ->add('compte')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
