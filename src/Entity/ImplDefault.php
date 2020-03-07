<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImplDefaultRepository")
 */
class ImplDefault
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
    private $value;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Implementation", inversedBy="implDefault", cascade={"persist", "remove"})
     */
    private $implementation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getImplementation(): ?Implementation
    {
        return $this->implementation;
    }

    public function setImplementation(?Implementation $implementation): self
    {
        $this->implementation = $implementation;

        return $this;
    }
}
