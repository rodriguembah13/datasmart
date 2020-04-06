<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StructureOffreServiceRepository")
 */
class StructureOffreService
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $themePrincipal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $breveDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienVideoPresentation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $texteBoutonAppel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objectifs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avantageDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $procedureLivraison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valeurOffre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valeurtotal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valeurPromotionelle;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $moyenPayement;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dureeOffre;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $upsell_dowsell;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comparaison;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienImage;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $textBref;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marqueConfiance;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avis;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilPrestataire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notificationVente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chiffrerassurant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bonusDation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $histoireEmouvante;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jeuxQuestion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conditionElegibilite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThemePrincipal(): ?string
    {
        return $this->themePrincipal;
    }

    public function setThemePrincipal(?string $themePrincipal): self
    {
        $this->themePrincipal = $themePrincipal;

        return $this;
    }

    public function getBreveDescription(): ?string
    {
        return $this->breveDescription;
    }

    public function setBreveDescription(?string $breveDescription): self
    {
        $this->breveDescription = $breveDescription;

        return $this;
    }

    public function getLienVideoPresentation(): ?string
    {
        return $this->lienVideoPresentation;
    }

    public function setLienVideoPresentation(?string $lienVideoPresentation): self
    {
        $this->lienVideoPresentation = $lienVideoPresentation;

        return $this;
    }

    public function getTexteBoutonAppel(): ?string
    {
        return $this->texteBoutonAppel;
    }

    public function setTexteBoutonAppel(?string $texteBoutonAppel): self
    {
        $this->texteBoutonAppel = $texteBoutonAppel;

        return $this;
    }

    public function getObjectifs(): ?string
    {
        return $this->objectifs;
    }

    public function setObjectifs(?string $objectifs): self
    {
        $this->objectifs = $objectifs;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getAvantageDescription(): ?string
    {
        return $this->avantageDescription;
    }

    public function setAvantageDescription(?string $avantageDescription): self
    {
        $this->avantageDescription = $avantageDescription;

        return $this;
    }

    public function getProcedureLivraison(): ?string
    {
        return $this->procedureLivraison;
    }

    public function setProcedureLivraison(?string $procedureLivraison): self
    {
        $this->procedureLivraison = $procedureLivraison;

        return $this;
    }

    public function getValeurOffre(): ?string
    {
        return $this->valeurOffre;
    }

    public function setValeurOffre(?string $valeurOffre): self
    {
        $this->valeurOffre = $valeurOffre;

        return $this;
    }

    public function getValeurtotal(): ?string
    {
        return $this->valeurtotal;
    }

    public function setValeurtotal(?string $valeurtotal): self
    {
        $this->valeurtotal = $valeurtotal;

        return $this;
    }

    public function getValeurPromotionelle(): ?string
    {
        return $this->valeurPromotionelle;
    }

    public function setValeurPromotionelle(?string $valeurPromotionelle): self
    {
        $this->valeurPromotionelle = $valeurPromotionelle;

        return $this;
    }

    public function getNotificationVente(): ?string
    {
        return $this->notificationVente;
    }

    public function setNotificationVente(?string $notificationVente): self
    {
        $this->notificationVente = $notificationVente;

        return $this;
    }

    public function getChiffrerassurant(): ?string
    {
        return $this->chiffrerassurant;
    }

    public function setChiffrerassurant(?string $chiffrerassurant): self
    {
        $this->chiffrerassurant = $chiffrerassurant;

        return $this;
    }

    public function getBonusDation(): ?string
    {
        return $this->bonusDation;
    }

    public function setBonusDation(?string $bonusDation): self
    {
        $this->bonusDation = $bonusDation;

        return $this;
    }

    public function getHistoireEmouvante(): ?string
    {
        return $this->histoireEmouvante;
    }

    public function setHistoireEmouvante(?string $histoireEmouvante): self
    {
        $this->histoireEmouvante = $histoireEmouvante;

        return $this;
    }

    public function getJeuxQuestion(): ?string
    {
        return $this->jeuxQuestion;
    }

    public function setJeuxQuestion(?string $jeuxQuestion): self
    {
        $this->jeuxQuestion = $jeuxQuestion;

        return $this;
    }

    public function getConditionElegibilite(): ?string
    {
        return $this->conditionElegibilite;
    }

    public function setConditionElegibilite(?string $conditionElegibilite): self
    {
        $this->conditionElegibilite = $conditionElegibilite;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMoyenPayement(): ?string
    {
        return $this->moyenPayement;
    }


    public function setMoyenPayement($moyenPayement): self
    {
        $this->moyenPayement = $moyenPayement;

        return $this;
    }


    public function getDureeOffre(): ?string
    {
        return $this->dureeOffre;
    }


    public function setDureeOffre($dureeOffre): self
    {
        $this->dureeOffre = $dureeOffre;

        return $this;
    }


    public function getUpsellDowsell(): ?string
    {
        return $this->upsell_dowsell;
    }


    public function setUpsellDowsell($upsell_dowsell): self
    {
        $this->upsell_dowsell = $upsell_dowsell;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComparaison(): ?string
    {
        return $this->comparaison;
    }


    public function setComparaison($comparaison): self
    {
        $this->comparaison = $comparaison;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLienImage(): ?string
    {
        return $this->lienImage;
    }


    public function setLienImage($lienImage): self
    {
        $this->lienImage = $lienImage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextBref(): ?string
    {
        return $this->textBref;
    }


    public function setTextBref($textBref): self
    {
        $this->textBref = $textBref;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMarqueConfiance(): ?string
    {
        return $this->marqueConfiance;
    }


    public function setMarqueConfiance($marqueConfiance): self
    {
        $this->marqueConfiance = $marqueConfiance;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvis(): ?string
    {
        return $this->avis;
    }


    public function setAvis($avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }


    public function setReference($reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfilPrestataire(): ?string
    {
        return $this->profilPrestataire;
    }

    public function setProfilPrestataire($profilPrestataire): self
    {
        $this->profilPrestataire = $profilPrestataire;

        return $this;
    }
}
