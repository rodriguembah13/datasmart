<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity="App\Entity\MembersStep", mappedBy="stepStrategy")
     */
    private $membersSteps;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Documentaire", mappedBy="stepStrategy")
     */
    private $documentaires;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Implementation", mappedBy="stepStrategy", cascade={"persist", "remove"})
     */
    private $implementation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planning", mappedBy="stepStrategy")
     */
    private $plannings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="stepStrategy")
     */
    private $comments;

    public function __construct()
    {
        $this->membersSteps = new ArrayCollection();
        $this->documentaires = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

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

    public function __toString()
    {
        return $this->getStep()->getName();
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
            $membersStep->setStepStrategy($this);
        }

        return $this;
    }

    public function removeMembersStep(MembersStep $membersStep): self
    {
        if ($this->membersSteps->contains($membersStep)) {
            $this->membersSteps->removeElement($membersStep);
            // set the owning side to null (unless already changed)
            if ($membersStep->getStepStrategy() === $this) {
                $membersStep->setStepStrategy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Documentaire[]
     */
    public function getDocumentaires(): Collection
    {
        return $this->documentaires;
    }

    public function addDocumentaire(Documentaire $documentaire): self
    {
        if (!$this->documentaires->contains($documentaire)) {
            $this->documentaires[] = $documentaire;
            $documentaire->setStepStrategy($this);
        }

        return $this;
    }

    public function removeDocumentaire(Documentaire $documentaire): self
    {
        if ($this->documentaires->contains($documentaire)) {
            $this->documentaires->removeElement($documentaire);
            // set the owning side to null (unless already changed)
            if ($documentaire->getStepStrategy() === $this) {
                $documentaire->setStepStrategy(null);
            }
        }

        return $this;
    }

    public function getImplementation(): ?Implementation
    {
        return $this->implementation;
    }

    public function setImplementation(?Implementation $implementation): self
    {
        $this->implementation = $implementation;

        // set (or unset) the owning side of the relation if necessary
        $newStepStrategy = null === $implementation ? null : $this;
        if ($implementation->getStepStrategy() !== $newStepStrategy) {
            $implementation->setStepStrategy($newStepStrategy);
        }

        return $this;
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings[] = $planning;
            $planning->setStepStrategy($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->contains($planning)) {
            $this->plannings->removeElement($planning);
            // set the owning side to null (unless already changed)
            if ($planning->getStepStrategy() === $this) {
                $planning->setStepStrategy(null);
            }
        }

        return $this;
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
            $comment->setStepStrategy($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getStepStrategy() === $this) {
                $comment->setStepStrategy(null);
            }
        }

        return $this;
    }

}
