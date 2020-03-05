<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StepRepository")
 */
class Step
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StepStrategy", mappedBy="step")
     */
    private $stepStrategies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Documentaire", mappedBy="step")
     */
    private $documentaires;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    public function __construct()
    {
        $this->stepStrategies = new ArrayCollection();
        $this->documentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|StepStrategy[]
     */
    public function getStepStrategies(): Collection
    {
        return $this->stepStrategies;
    }

    public function addStepStrategy(StepStrategy $stepStrategy): self
    {
        if (!$this->stepStrategies->contains($stepStrategy)) {
            $this->stepStrategies[] = $stepStrategy;
            $stepStrategy->setStep($this);
        }

        return $this;
    }

    public function removeStepStrategy(StepStrategy $stepStrategy): self
    {
        if ($this->stepStrategies->contains($stepStrategy)) {
            $this->stepStrategies->removeElement($stepStrategy);
            // set the owning side to null (unless already changed)
            if ($stepStrategy->getStep() === $this) {
                $stepStrategy->setStep(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->name;
    }

    /**
     * @return Collection|Documentaire[]
     */
    public function getDocumentaires(): Collection
    {
        return $this->documentaires;
    }

    public function addDocumentaire(Documentaire $documentaire): self
    {
        if (!$this->documentaires->contains($documentaire)) {
            $this->documentaires[] = $documentaire;
            $documentaire->setStep($this);
        }

        return $this;
    }

    public function removeDocumentaire(Documentaire $documentaire): self
    {
        if ($this->documentaires->contains($documentaire)) {
            $this->documentaires->removeElement($documentaire);
            // set the owning side to null (unless already changed)
            if ($documentaire->getStep() === $this) {
                $documentaire->setStep(null);
            }
        }

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

}
