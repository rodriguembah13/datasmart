<?php

namespace App\Form;

use App\Entity\StructureOffreService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('themePrincipal')
            ->add('breveDescription', TextareaType::class, [
                'required' => false,
            ])
            ->add('lienVideoPresentation')
            ->add('texteBoutonAppel')
            ->add('objectifs', TextareaType::class, [
                'required' => false,
            ])
            ->add('contenu', TextareaType::class, [
                'required' => false,
            ])
            ->add('avantageDescription', TextareaType::class, [
                'required' => false,
            ])
            ->add('procedureLivraison', TextareaType::class, [
                'required' => false,
            ])
            ->add('valeurOffre')
            ->add('valeurtotal')
            ->add('valeurPromotionelle')
            ->add('moyenPayement')
            ->add('dureeOffre')
            ->add('upsell_dowsell')
            ->add('comparaison', TextareaType::class, [
                'required' => false,
            ])
            ->add('lienImage')
            ->add('textBref', TextareaType::class, [
                'required' => false,
            ])
            ->add('marqueConfiance')
            ->add('avis', TextareaType::class, [
                'required' => false,
            ])
            ->add('reference')
            ->add('profilPrestataire')
            ->add('notificationVente')
            ->add('chiffrerassurant')
            ->add('bonusDation')
            ->add('histoireEmouvante', TextareaType::class, [
                'required' => false,
            ])
            ->add('jeuxQuestion')
            ->add('conditionElegibilite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StructureOffreService::class,
        ]);
    }
}
