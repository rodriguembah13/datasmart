<?php

namespace App\DataFixtures;

use App\Entity\Step;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class StepFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=Factory::create();
        $step = new Step();
        $step->setName('Planification détaillée de la mise en œuvre de la stratégie de marketing digitale');
        $step2 = new Step();
        $step2->setName('Définition des objectifs de base à atteindre');
        $step3 = new Step();
        $step3->setName('Identification de la cible principale ou du client idéal (AVATAR)');
        $step4 = new Step();
        $step4->setName('Conception de l’offre irrésistible pour le client idéal précédemment identifié');
        $step5 = new Step();
        $step5->setName('Conception structurelle de la stratégie de marketing digital (Schéma général de stratégie)');
        $step6 = new Step();
        $step6->setName('Description des scenarios de la politique et stratégie de marketing digital');
        $step7 = new Step();
        $step7->setName('Récapitulatif des contenus à monter pour la mise en œuvre des scenarios de la stratégie initiale');
        $step8 = new Step();
        $step8->setName('Simulation des résultats de la stratégie par rapport aux objectifs fixés (s’il y a lieu)');
        $step9 = new Step();
        $step9->setName('Identification et déploiement des outils pour la stratégie digitale');
        $step10 = new Step();
        $step10->setName('Conception et implémentation du site web approprié, en lien avec les objectifs à atteindre (s’il y a lieu)');
        $step11 = new Step();
        $step11->setName('Coaching à la mise en œuvre de l’effet levier dans le processus de livraison (s’il y a lieu)');
        $step12 = new Step();
        $step12->setName('Implémentation de l’entonnoir de vente');
        $step13 = new Step();
        $step13->setName('Lancement des premières campagnes marketings');
        $step14 = new Step();
        $step14->setName('Test et optimisation de la stratégie de marketing digitale mise en œuvre');
        $step15 = new Step();
        $step15->setName('Optimisation du processus de Closing ou de vente (s’il y a lieu)');
        $manager->persist($step);
        $manager->persist($step2);
        $manager->persist($step3);
        $manager->persist($step4);
        $manager->persist($step5);
        $manager->persist($step6);
        $manager->persist($step7);
        $manager->persist($step8);
        $manager->persist($step9);
        $manager->persist($step10);
        $manager->persist($step11);
        $manager->persist($step12);
        $manager->persist($step13);
        $manager->persist($step14);
        $manager->persist($step15);

        $manager->flush();
    }
}
