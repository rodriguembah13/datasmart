<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="comments")
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Response", mappedBy="comment")
     */
    private $response;

    public function __construct()
    {
        $this->response = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return Collection|Response[]
     */
    public function getResponse(): Collection
    {
        return $this->response;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->response->contains($response)) {
            $this->response[] = $response;
            $response->setComment($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->response->contains($response)) {
            $this->response->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getComment() === $this) {
                $response->setComment(null);
            }
        }

        return $this;
    }
}
