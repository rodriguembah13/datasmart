<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StepStrategyRepository")
 */
class StepStrategy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StrategyDigital", inversedBy="stepStrategies")
     */
    private $strategy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Step", inversedBy="stepStrategies")
     */
    private $step;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PlanningStrategy", mappedBy="stepStrategy", cascade={"persist", "remove"})
     */
    private $planning;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Response", mappedBy="stepStrategy", cascade={"persist", "remove"})
     */
    private $response;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStrategy(): ?StrategyDigital
    {
        return $this->strategy;
    }

    public function setStrategy(?StrategyDigital $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function getStep(): ?Step
    {
        return $this->step;
    }

    public function setStep(?Step $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): self
    {
        $this->response = $response;

        // set (or unset) the owning side of the relation if necessary
        $newStepStrategy = null === $response ? null : $this;
        if ($response->getStepStrategy() !== $newStepStrategy) {
            $response->setStepStrategy($newStepStrategy);
        }

        return $this;
    }

    public function getPlanning(): ?PlanningStrategy
    {
        return $this->planning;
    }

    public function setPlanning(PlanningStrategy $planning): self
    {
        $this->planning = $planning;
        // set (or unset) the owning side of the relation if necessary
        $newStepStrategy = null === $planning ? null : $this;
        if ($planning->getStepStrategy() !== $newStepStrategy) {
            $planning->setStepStrategy($newStepStrategy);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getStep()->getName();
    }

}
