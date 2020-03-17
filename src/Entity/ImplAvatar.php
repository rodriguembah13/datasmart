<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImplAvatarRepository")
 */
class ImplAvatar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Implementation", inversedBy="implAvatar", cascade={"persist", "remove"})
     */
    private $implementation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CibleAvatar", mappedBy="implAvatar")
     */
    private $cibleAvatars;
//use ColunmValidate;
    public function __construct()
    {
        $this->cibleAvatars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|CibleAvatar[]
     */
    public function getCibleAvatars(): Collection
    {
        return $this->cibleAvatars;
    }

    public function addCibleAvatar(CibleAvatar $cibleAvatar): self
    {
        if (!$this->cibleAvatars->contains($cibleAvatar)) {
            $this->cibleAvatars[] = $cibleAvatar;
            $cibleAvatar->setImplAvatar($this);
        }

        return $this;
    }

    public function removeCibleAvatar(CibleAvatar $cibleAvatar): self
    {
        if ($this->cibleAvatars->contains($cibleAvatar)) {
            $this->cibleAvatars->removeElement($cibleAvatar);
            // set the owning side to null (unless already changed)
            if ($cibleAvatar->getImplAvatar() === $this) {
                $cibleAvatar->setImplAvatar(null);
            }
        }

        return $this;
    }


}
