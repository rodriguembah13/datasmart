<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\CustomerUser;
use App\Entity\Employee;
use App\Entity\Step;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class FakerFixtures extends Fixture
{
    /**
     * FakerFixtures constructor.
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);
        /* $step=[];
         for ($i=0;$i<14;$i++){
             $step[$i]=new Step();
             $step[$i]->setName($faker->title);
         }*/
        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user->setEnabled(true);
            $user->setPlainPassword('12345');
            $user->setUsername($faker->userName);
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_CUSTOMER']);
            $manager->persist($user);
            $customer = new Customer();
            $customer->setAddress($faker->address);
            $customer->setCompany($faker->company);
            $customer->setDateFrom($faker->dateTime);
            $customer->setLabel($faker->jobTitle);
            $customer->setName($faker->name);
            $customer->setRegisteredAt($faker->dateTime);
            $customer->setTelephone($faker->phoneNumber);
            $customer->setCompte($user);
            $manager->persist($customer);
            $rand = rand(5, 8);
            for ($ii = 0; $ii < 5; ++$ii) {
                $user2 = new User();
                $user2->setEnabled(true);
                $user2->setPlainPassword('12345');
                $user2->setUsername($faker->userName);
                $user2->setEmail($faker->email);
                $user2->setRoles(['ROLE_USER']);
                $manager->persist($user2);
                $customeruser = new CustomerUser();
                $customeruser->setName($faker->lastName.' '.$faker->firstName);
                $customeruser->setCreatedBy($customer);
                $customeruser->setVisible($faker->boolean);
                $customeruser->setCompte($user2);
                $manager->persist($customeruser);
            }
        }

        for ($k = 0; $k < 5; ++$k) {
            $user = new User();
            $user->setEnabled(true);
            $user->setPlainPassword('12345');
            $user->setUsername($faker->userName);
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
            $employee = new Employee();
            $employee->setName($faker->name);
            $employee->setIsCoach($faker->boolean);
            $employee->setCompte($user);
            $manager->persist($employee);
        }
        $manager->flush();
    }
}
