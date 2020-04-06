<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImplOffreRepository")
 */
class ImplOffre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Implementation", mappedBy="implOffre", cascade={"persist", "remove"})
     */
    private $implementation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StructureOffreService")
     */
    private $structureService;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImplementation(): ?Implementation
    {
        return $this->implementation;
    }

    public function setImplementation(?Implementation $implementation): self
    {
        $this->implementation = $implementation;

        // set (or unset) the owning side of the relation if necessary
        $newImplOffre = null === $implementation ? null : $this;
        if ($implementation->getImplOffre() !== $newImplOffre) {
            $implementation->setImplOffre($newImplOffre);
        }

        return $this;
    }

    public function getStructureService(): ?StructureOffreService
    {
        return $this->structureService;
    }

    public function setStructureService(?StructureOffreService $structureService): self
    {
        $this->structureService = $structureService;

        return $this;
    }
}
