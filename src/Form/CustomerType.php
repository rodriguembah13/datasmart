<?php

namespace App\Form;

use App\Entity\Customer;
use App\Security\RoleService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    /**
     * @var RoleService
     */
    private $roles = [];

    public function __construct(RoleService $roles)
    {
        $this->roles = $roles;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_from', DateType::class, [
        'widget' => 'single_text',
        'html5' => false,
        'required' => false,
    ])
            ->add('date_to', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
            ])
            ->add('name')
            //->add('value')
            //->add('visible')
            ->add('company')
            ->add('address')
            ->add('telephone')
            //->add('registeredAt')
           // ->add('createdBy')
            //->add('compte', new UserType($this->roles))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
