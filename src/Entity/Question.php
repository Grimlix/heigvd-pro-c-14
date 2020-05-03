<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\AbstractType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question extends AbstractType
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $answers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $open;

    /**
     * @ORM\Column(type="boolean")
     */
    private $close;


    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->answers = new ArrayCollection();
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

    public function setText(string $text){
        $this->text = $text;
        return $this;
    }

    public function getOpen(): ?boolean{
        return $this->open;
    }
    public function setOpen(bool $open){
        $this->open = $open;
        return $this;
    }

    public function getClose(): ?boolean{
        return $this->close;
    }
    public function setClose(bool $close){
        $this->close = $close;
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

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }
}
