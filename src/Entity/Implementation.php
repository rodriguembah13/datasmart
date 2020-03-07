<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImplementationRepository")
 */
class Implementation
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
    private $reference;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StepStrategy", inversedBy="implementation", cascade={"persist", "remove"})
     */
    private $stepStrategy;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ImplPlanning", mappedBy="implementation", cascade={"persist", "remove"})
     */
    private $implPlanning;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ImplObjectif", mappedBy="implementation", cascade={"persist", "remove"})
     */
    private $implObjectif;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ImplDefault", mappedBy="implementation", cascade={"persist", "remove"})
     */
    private $implDefault;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStepStrategy(): ?StepStrategy
    {
        return $this->stepStrategy;
    }

    public function setStepStrategy(?StepStrategy $stepStrategy): self
    {
        $this->stepStrategy = $stepStrategy;

        return $this;
    }

    public function getImplPlanning(): ?ImplPlanning
    {
        return $this->implPlanning;
    }

    public function setImplPlanning(?ImplPlanning $implPlanning): self
    {
        $this->implPlanning = $implPlanning;

        // set (or unset) the owning side of the relation if necessary
        $newImplementation = null === $implPlanning ? null : $this;
        if ($implPlanning->getImplementation() !== $newImplementation) {
            $implPlanning->setImplementation($newImplementation);
        }

        return $this;
    }

    public function getImplObjectif(): ?ImplObjectif
    {
        return $this->implObjectif;
    }

    public function setImplObjectif(?ImplObjectif $implObjectif): self
    {
        $this->implObjectif = $implObjectif;

        // set (or unset) the owning side of the relation if necessary
        $newImplementation = null === $implObjectif ? null : $this;
        if ($implObjectif->getImplementation() !== $newImplementation) {
            $implObjectif->setImplementation($newImplementation);
        }

        return $this;
    }

    public function getImplDefault(): ?ImplDefault
    {
        return $this->implDefault;
    }

    public function setImplDefault(?ImplDefault $implDefault): self
    {
        $this->implDefault = $implDefault;

        // set (or unset) the owning side of the relation if necessary
        $newImplementation = null === $implDefault ? null : $this;
        if ($implDefault->getImplementation() !== $newImplementation) {
            $implDefault->setImplementation($newImplementation);
        }

        return $this;
    }
}
