<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StrategyDigitalRepository")
 */
class StrategyDigital
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
     * @ORM\OneToMany(targetEntity="App\Entity\StepStrategy", mappedBy="strategy")
     */
    private $stepStrategies;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="strategyDigitals")
     */
    private $createBy;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CustomerUser", inversedBy="strategyDigitals")
     */
    private $lead;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeOffre;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $subTypeOffre = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subTypeProduit;


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
            $stepStrategy->setStrategy($this);
        }

        return $this;
    }

    public function removeStepStrategy(StepStrategy $stepStrategy): self
    {
        if ($this->stepStrategies->contains($stepStrategy)) {
            $this->stepStrategies->removeElement($stepStrategy);
            // set the owning side to null (unless already changed)
            if ($stepStrategy->getStrategy() === $this) {
                $stepStrategy->setStrategy(null);
            }
        }

        return $this;
    }

    public function getCreateBy(): ?Customer
    {
        return $this->createBy;
    }

    public function setCreateBy(?Customer $createBy): self
    {
        $this->createBy = $createBy;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getLead(): ?CustomerUser
    {
        return $this->lead;
    }

    public function setLead(?CustomerUser $lead): self
    {
        $this->lead = $lead;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getTypeOffre(): ?string
    {
        return $this->typeOffre;
    }

    public function setTypeOffre(?string $typeOffre): self
    {
        $this->typeOffre = $typeOffre;

        return $this;
    }

    public function getSubTypeOffre(): ?array
    {
        return $this->subTypeOffre;
    }

    public function setSubTypeOffre(?array $subTypeOffre): self
    {
        $this->subTypeOffre = $subTypeOffre;

        return $this;
    }

    public function getSubTypeProduit(): ?string
    {
        return $this->subTypeProduit;
    }

    public function setSubTypeProduit(?string $subTypeProduit): self
    {
        $this->subTypeProduit = $subTypeProduit;

        return $this;
    }

}
