<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CustomerUser", mappedBy="createdBy")
     */
    private $customerUsers;

    /**
     * @ORM\Column(type="date")
     */
    private $date_from;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_to;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="customers")
     */
    private $createdBy;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="customer", cascade={"persist", "remove"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StrategyDigital", mappedBy="createBy")
     */
    private $strategyDigitals;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telephone;
    use ColunmTrait;
    public function __construct()
    {
        $this->customerUsers = new ArrayCollection();
        $this->strategyDigitals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|CustomerUser[]
     */
    public function getCustomerUsers(): Collection
    {
        return $this->customerUsers;
    }

    public function addCustomerUser(CustomerUser $customerUser): self
    {
        if (!$this->customerUsers->contains($customerUser)) {
            $this->customerUsers[] = $customerUser;
            $customerUser->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCustomerUser(CustomerUser $customerUser): self
    {
        if ($this->customerUsers->contains($customerUser)) {
            $this->customerUsers->removeElement($customerUser);
            // set the owning side to null (unless already changed)
            if ($customerUser->getCreatedBy() === $this) {
                $customerUser->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->date_from;
    }

    public function setDateFrom(\DateTimeInterface $date_from): self
    {
        $this->date_from = $date_from;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->date_to;
    }

    public function setDateTo(?\DateTimeInterface $date_to): self
    {
        $this->date_to = $date_to;

        return $this;
    }

    public function getCreatedBy(): ?Employee
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Employee $createdBy): self
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
            $strategyDigital->setCreateBy($this);
        }

        return $this;
    }

    public function removeStrategyDigital(StrategyDigital $strategyDigital): self
    {
        if ($this->strategyDigitals->contains($strategyDigital)) {
            $this->strategyDigitals->removeElement($strategyDigital);
            // set the owning side to null (unless already changed)
            if ($strategyDigital->getCreateBy() === $this) {
                $strategyDigital->setCreateBy(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

}
