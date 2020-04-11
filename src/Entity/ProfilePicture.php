<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilePictureRepository")
 */
class ProfilePicture
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
    private $pictureName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picturePath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureName(): ?string
    {
        return $this->pictureName;
    }

    public function setPictureName(string $pictureName): self
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    public function setPicturePath(string $picturePath): self
    {
        $this->picturePath = $picturePath;

        return $this;
    }
}
