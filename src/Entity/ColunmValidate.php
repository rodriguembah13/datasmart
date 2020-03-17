<?php
/**
 * Created by PhpStorm.
 * User: smartworld
 * Date: 3/17/20
 * Time: 9:06 AM.
 */

namespace App\Entity;

trait ColunmValidate
{
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valideCustomer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valideCoach;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $userCustomer;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $userCoach;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateValidateCoach;

    /**
     * @return mixed
     */
    public function getDateValidateCoach():?\DateTimeInterface
    {
        return $this->dateValidateCoach;
    }

    /**
     * @param mixed $dateValidateCoach
     */
    public function setDateValidateCoach(?\DateTimeInterface $dateValidateCoach): self
    {
        $this->dateValidateCoach = $dateValidateCoach;
        return $this;
    }

    public function getUserCustomer(): ?User
    {
        return $this->userCustomer;
    }

    public function setUserCustomer(?User $userCustomer): self
    {
        $this->userCustomer = $userCustomer;
        return $this;
    }

    public function getUserCoach(): ?User
    {
        return $this->userCoach;
    }

    public function setUserCoach(?User $userCoach): self
    {
        $this->userCoach = $userCoach;
        return $this;
    }

    public function getValideCustomer(): ?bool
    {
        return $this->valideCustomer;
    }

    public function setValideCustomer(?bool $valideCustomer): self
    {
        $this->valideCustomer = $valideCustomer;

        return $this;
    }

    public function getValideCoach(): ?bool
    {
        return $this->valideCoach;
    }

    public function setValideCoach(?bool $valideCoach): self
    {
        $this->valideCoach = $valideCoach;

        return $this;
    }
}
