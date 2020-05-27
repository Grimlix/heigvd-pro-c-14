<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
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
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $answers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $open;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="questions")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $close;


    public function __construct($user)
    {
        $this->tags = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->open = false;
        $this->close = false;
        $this->setUser($user);
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

    public function getOpen(): ?bool{
        return $this->open;
    }
    public function setOpen(bool $open){
        $this->open = $open;
        return $this;
    }

    public function getClose(): ?bool{
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



    public function setUser(?User $user): self{
        $this->user = $user;
        return $this;
    }


    public function getUser(): ?User{
        return $this->user;
    }
}
