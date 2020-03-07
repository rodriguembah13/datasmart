<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


class Question
{

    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
