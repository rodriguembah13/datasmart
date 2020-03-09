<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CibleAvatarRepository")
 */
class CibleAvatar
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
    private $question;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ImplAvatar", inversedBy="cibleAvatars")
     */
    private $implAvatar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getImplAvatar(): ?ImplAvatar
    {
        return $this->implAvatar;
    }

    public function setImplAvatar(?ImplAvatar $implAvatar): self
    {
        $this->implAvatar = $implAvatar;

        return $this;
    }
}
