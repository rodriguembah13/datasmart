<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class PlanningStrategy
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
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StepStrategy", inversedBy="planning", cascade={"persist", "remove"})
     */
    private $stepStrategy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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
