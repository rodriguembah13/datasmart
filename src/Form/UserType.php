<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\User;
use App\Security\RoleService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @var RoleService
     */
    private $roles;

    public function __construct(RoleService $roles)
    {
        $this->roles = $roles;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('roles', ChoiceType::class, [
                'choices' => $this->getRoles(),
                'multiple' => true,
                'expanded' => true,
            ])
           /*->add('groups', EntityType::class, [
               'class' => Group::class,
                'multiple' => true,
            ])*/
           ;
    }

    public function getRoles()
    {
        $roles = [];
        foreach ($this->roles->getAvailableNames() as $name) {
            $roles[$name] = strtoupper($name);
        }

        if (isset($roles[User::DEFAULT_ROLE])) {
            unset($roles[User::DEFAULT_ROLE]);
        }

        return $roles;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
