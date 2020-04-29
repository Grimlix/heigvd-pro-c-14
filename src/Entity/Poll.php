<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\PoolRepository")
 * @ORM\Table(
 *     name="poll",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"user_id","name"})}
 * )
 * @UniqueEntity(
 *     fields={"user","name"},
 *     message="Vous avez deja un poll portant ce nom"
 * )
 * @UniqueEntity("passToken")
 */
class Poll
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $passToken;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="poll", orphanRemoval=true)
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="polls")
     */
    private $user;

    public function __construct($user){
        $this->questions = new ArrayCollection();
        $this->setUser($user);
    }

    /* For easyAdmin */
    public function __toString(){
        return $this->name;
    }

    public function getPassToken(){
        return $this->passToken;
    }

    public function setPassToken(string $str){
        $this->passToken = $str;
        return $this;
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
            $question->setPoll($this);
        }
        return $this;
    }

    public function removeQuestion(Question $question): self{
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getPoll() === $this) {
                $question->setPoll(null);
            }
        }
        return $this;
    }

    public function getUser(): ?User{
        return $this->user;
    }

    public function setUser(?User $user): self{
        $this->user = $user;
        return $this;
    }
}
