<?php

namespace App\Entity;

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
}
