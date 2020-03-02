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

    public function __construct()
    {
        $this->stepStrategies = new ArrayCollection();
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

}
