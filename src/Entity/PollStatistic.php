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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $passToken;

    public function getPassToken(): ?string {
        return $this->$this->passToken;
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

    public function __construct($token){
        $this->passToken = $token;
        $this->setCount(0);
    }
}
