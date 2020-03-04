<?php

namespace App\Form;

use App\Entity\CustomerUser;
use App\Entity\StrategyDigital;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class StrategyDigitalEditType extends AbstractType
{
    private $security;

    /**
     * StrategyDigitalEditType constructor.
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $this->security->getUser()->getCustomerUser();
        $builder
            ->add('name')
            ->add('lead', EntityType::class, [
                'class' => CustomerUser::class,
                'placeholder' => 'Select your lead',
                'choices' => $data,
                'multiple' => false,
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
