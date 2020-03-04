<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCoach;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Customer", mappedBy="createdBy")
     */
    private $customers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="employee", cascade={"persist", "remove"})
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="employee")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer", mappedBy="coachs")
     */
    private $customersCoach;
    use ColunmTrait;
    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->customersCoach = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsCoach(): ?bool
    {
        return $this->isCoach;
    }

    public function setIsCoach(bool $isCoach): self
    {
        $this->isCoach = $isCoach;

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getCreatedBy() === $this) {
                $customer->setCreatedBy(null);
            }
        }

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
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEmployee($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getEmployee() === $this) {
                $comment->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomersCoach(): Collection
    {
        return $this->customersCoach;
    }

    public function addCustomersCoach(Customer $customersCoach): self
    {
        if (!$this->customersCoach->contains($customersCoach)) {
            $this->customersCoach[] = $customersCoach;
            $customersCoach->addCoach($this);
        }

        return $this;
    }

    public function removeCustomersCoach(Customer $customersCoach): self
    {
        if ($this->customersCoach->contains($customersCoach)) {
            $this->customersCoach->removeElement($customersCoach);
            $customersCoach->removeCoach($this);
        }

        return $this;
    }
}
