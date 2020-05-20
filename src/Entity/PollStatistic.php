<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PollStatisticRepository")
 */
class PollStatistic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $count;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Answer", inversedBy="poll_statistic")
     * @ORM\Column(type="integer")
     */
    private $answer_id;

    /**
     * @return mixed
     */
    public function getanswer_id()
    {
        return $this->answer_id;
    }

    /**
     * @param mixed $answer_id
     */
    public function setAnswerId($answer_id): void
    {
        $this->answer_id = $answer_id;
    }

    public function __construct($answerID){
        $this->answer_id = $answerID;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int{
        return $this->count;
    }
    public function setCount(int $count){
        $this->count = $count;
        return $this;
    }
}
