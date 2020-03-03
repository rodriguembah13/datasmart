<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerUserRepository")
 */
class CustomerUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="customerUsers")
     */
    private $createdBy;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MembersStep", mappedBy="customerUser")
     */
    private $membersSteps;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StrategyDigital", mappedBy="lead")
     */
    private $strategyDigitals;

    public function __construct()
    {
        $this->membersSteps = new ArrayCollection();
        $this->strategyDigitals = new ArrayCollection();
    }
    use ColunmTrait;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedBy(): ?Customer
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Customer $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(?User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|MembersStep[]
     */
    public function getMembersSteps(): Collection
    {
        return $this->membersSteps;
    }

    public function addMembersStep(MembersStep $membersStep): self
    {
        if (!$this->membersSteps->contains($membersStep)) {
            $this->membersSteps[] = $membersStep;
            $membersStep->setCustomerUser($this);
        }

        return $this;
    }

    public function removeMembersStep(MembersStep $membersStep): self
    {
        if ($this->membersSteps->contains($membersStep)) {
            $this->membersSteps->removeElement($membersStep);
            // set the owning side to null (unless already changed)
            if ($membersStep->getCustomerUser() === $this) {
                $membersStep->setCustomerUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StrategyDigital[]
     */
    public function getStrategyDigitals(): Collection
    {
        return $this->strategyDigitals;
    }

    public function addStrategyDigital(StrategyDigital $strategyDigital): self
    {
        if (!$this->strategyDigitals->contains($strategyDigital)) {
            $this->strategyDigitals[] = $strategyDigital;
            $strategyDigital->setLead($this);
        }

        return $this;
    }

    public function removeStrategyDigital(StrategyDigital $strategyDigital): self
    {
        if ($this->strategyDigitals->contains($strategyDigital)) {
            $this->strategyDigitals->removeElement($strategyDigital);
            // set the owning side to null (unless already changed)
            if ($strategyDigital->getLead() === $this) {
                $strategyDigital->setLead(null);
            }
        }

        return $this;
    }
}
