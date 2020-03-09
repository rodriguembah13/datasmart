<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 */
class Planning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateBegin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ImplPlanning", inversedBy="plannings")
     */
    private $implPlanning;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StepStrategy", inversedBy="plannings")
     */
    private $stepStrategy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(?\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getImplPlanning(): ?ImplPlanning
    {
        return $this->implPlanning;
    }

    public function setImplPlanning(?ImplPlanning $implPlanning): self
    {
        $this->implPlanning = $implPlanning;

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
}
