<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setPlainPassword('admin');
        $user->setUsername('admin');
        $user->setEnabled(true);
        $user->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN']);
        $manager->persist($user);

        $employee = new Employee();
        $employee->setIsCoach(true);
        $employee->setCompte($user);
        $employee->setName('Smartworld');
        $employee->setVisible(true);
        $employee->setRegisteredAt(new \DateTime('now'));
        $manager->persist($employee);
        $manager->flush();
    }
}
