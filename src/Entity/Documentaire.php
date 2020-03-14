<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentaireRepository")
 */
class Documentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienVideo;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lienFile;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Step", inversedBy="documentaires")
     */
    private $step;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getStep(): ?Step
    {
        return $this->step;
    }

    public function setStep(?Step $step): self
    {
        $this->step = $step;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLienVideo()
    {
        return $this->lienVideo;
    }

    /**
     * @param mixed $lienVideo
     */
    public function setLienVideo($lienVideo): void
    {
        $this->lienVideo = $lienVideo;
    }

    /**
     * @return mixed
     */
    public function getLienFile()
    {
        return $this->lienFile;
    }

    /**
     * @param mixed $lienFile
     */
    public function setLienFile($lienFile): void
    {
        $this->lienFile = $lienFile;
    }

}
