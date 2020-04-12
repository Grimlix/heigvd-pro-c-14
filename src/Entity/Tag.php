<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", mappedBy="tags")
     */
    private $questions;

    public function __construct(){
        $this->questions = new ArrayCollection();
    }

    public function __toString(){
        return $this->name;
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getName(): ?string{
        return $this->name;
    }

    public function setName(string $name): self{
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection{
        return $this->questions;
    }

    public function addQuestion(Question $question): self{
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->addTag($this);
        }
        return $this;
    }

    public function removeQuestion(Question $question): self{
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            $question->removeTag($this);
        }
        return $this;
    }
}
