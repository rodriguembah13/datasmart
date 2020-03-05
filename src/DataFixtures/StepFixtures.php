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

        $step = new Step();
        $step->setName('Planification détaillée de la mise en œuvre de la stratégie de marketing digitale');
        $step->setValue('Planification_détaillée_de_la_mise_en_œuvre_de_la_stratégie_de_marketing_digitale');
        $step2 = new Step();
        $step2->setName('Définition des objectifs de base à atteindre');
        $step2->setValue('Définition_des_objectifs_de_base_à_atteindre');
        $step3 = new Step();
        $step3->setName('Identification de la cible principale ou du client idéal (AVATAR)');
        $step3->setValue('Identification_de_la_cible_principale_ou_du_client_idéal');
        $step4 = new Step();
        $step4->setName('Conception de l’offre irrésistible pour le client idéal précédemment identifié');
        $step4->setValue('Conception_de_offre_irrésistible_pour_le_client_idéal_précédemment_identifié');
        $step5 = new Step();
        $step5->setName('Conception structurelle de la stratégie de marketing digital (Schéma général de stratégie)');
        $step5->setValue('Conception_structurelle_de_la_stratégie_de_marketing_digital');
        $step6 = new Step();
        $step6->setName('Description des scenarios de la politique et stratégie de marketing digital');
        $step6->setValue('Description_des_scenarios_de_la_politique_et_stratégie_de_marketing_digital');
        $step7 = new Step();
        $step7->setName('Récapitulatif des contenus à monter pour la mise en œuvre des scenarios de la stratégie initiale');
        $step7->setValue('Récapitulatif_des_contenus_à_monter_pour_la_mise_en_œuvre_des_scenarios_de_la_stratégie_initiale');
        $step8 = new Step();
        $step8->setName('Simulation des résultats de la stratégie par rapport aux objectifs fixés (s’il y a lieu)');
        $step8->setValue('Simulation_des_résultats_de_la_stratégie_par_rapport_aux_objectifs_fixés');
        $step9 = new Step();
        $step9->setName('Identification et déploiement des outils pour la stratégie digitale');
        $step9->setValue('Identification_et_déploiement_des_outils_pour_la_stratégie_digitale');
        $step10 = new Step();
        $step10->setName('Conception et implémentation du site web approprié, en lien avec les objectifs à atteindre (s’il y a lieu)');
        $step10->setValue('Conception_et_implémentation_du_site_web_approprié_en_lien_avec_les_objectifs_à_atteindre');
        $step11 = new Step();
        $step11->setName('Coaching à la mise en œuvre de l’effet levier dans le processus de livraison (s’il y a lieu)');
        $step11->setValue('Coaching_à_la_mise_en_œuvre_de_l_effet_levier_dans_le_processus_de_livraison');
        $step12 = new Step();
        $step12->setName('Implémentation de l’entonnoir de vente');
        $step12->setValue('Implémentation_de_lentonnoir_de_vente');
        $step13 = new Step();
        $step13->setName('Lancement des premières campagnes marketings');
        $step13->setValue('Lancement_des_premières_campagnes_marketings');
        $step14 = new Step();
        $step14->setName('Test et optimisation de la stratégie de marketing digitale mise en œuvre');
        $step14->setValue('Test_et_optimisation_de_la_stratégie_de_marketing_digitale_mise_en_œuvre');
        $step15 = new Step();
        $step15->setName('Optimisation du processus de Closing ou de vente (s’il y a lieu)');
        $step15->setValue('Optimisation_du_processus_de_Closing_ou_de_vente');
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
