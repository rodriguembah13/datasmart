<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResponseRepository")
 */
class Response
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StepStrategy", inversedBy="response", cascade={"persist", "remove"})
     */
    private $stepStrategy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="response")
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResponseStep", mappedBy="response")
     */
    private $responseSteps;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->responseSteps = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
            $comment->setResponse($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getResponse() === $this) {
                $comment->setResponse(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|ResponseStep[]
     */
    public function getResponseSteps(): Collection
    {
        return $this->responseSteps;
    }

    public function addResponseStep(ResponseStep $responseStep): self
    {
        if (!$this->responseSteps->contains($responseStep)) {
            $this->responseSteps[] = $responseStep;
            $responseStep->setResponse($this);
        }

        return $this;
    }

    public function removeResponseStep(ResponseStep $responseStep): self
    {
        if ($this->responseSteps->contains($responseStep)) {
            $this->responseSteps->removeElement($responseStep);
            // set the owning side to null (unless already changed)
            if ($responseStep->getResponse() === $this) {
                $responseStep->setResponse(null);
            }
        }

        return $this;
    }
}
