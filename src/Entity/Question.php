<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Poll", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poll;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="questions")
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /* For easyAdmin */
    public function __toString(){
        return $this->text;
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getText(): ?string{
        return $this->text;
    }

    public function setText(string $text): self{
        $this->text = $text;

        return $this;
    }

    public function getPoll(): ?Poll{
        return $this->poll;
    }

    public function setPoll(?Poll $poll): self{
        $this->poll = $poll;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}
