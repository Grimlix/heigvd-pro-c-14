<?php
        // src/AppBundle/Entity/User.php

        namespace App\Entity;

        use Doctrine\Common\Collections\ArrayCollection;
        use Doctrine\Common\Collections\Collection;
        use FOS\UserBundle\Model\User as BaseUser;
        use Doctrine\ORM\Mapping as ORM;
        use FOS\UserBundle\Model\UserInterface;

        /**
        * @ORM\Entity
        *@ORM\Table(name="`user`")
        */
        class User extends BaseUser implements UserInterface
        {
            /**
             * @var string
             */
            protected $plainPassword;

            /**
             * @ORM\Id
             *@ORM\GeneratedValue(strategy="AUTO")
             *@ORM\Column(type="integer")
             */
            protected $id;

            /**
             * @ORM\OneToMany(targetEntity="App\Entity\Poll", mappedBy="user")
             */
            private $polls;

            /**
             * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="user")
             */
            private $questions;

            public function __construct()
            {
                parent::__construct();
                $this->polls = new ArrayCollection();
                $this->questions = new ArrayCollection();
            }


            public function getPlainPassword(): ?string
            {
                return $this->plainPassword;
            }

            public function setPlainPassword($password): User
            {
                $this->plainPassword = $password;
                return $this;
            }

            /**
             * @return Collection|Poll[]
             */
            public function getPolls(): Collection
            {
                return $this->polls;
            }

            /**
             * @return Collection|Question[]
             */
            public function getQuestions(): Collection
            {
                return $this->questions;
            }

            public function addPoll(Poll $poll): self
            {
                if (!$this->polls->contains($poll)) {
                    $this->polls[] = $poll;
                    $poll->setUser($this);
                }

                return $this;
            }

            public function removePoll(Poll $poll): self
            {
                if ($this->polls->contains($poll)) {
                    $this->polls->removeElement($poll);
                    // set the owning side to null (unless already changed)
                    if ($poll->getUser() === $this) {
                        $poll->setUser(null);
                    }
                }

                return $this;
            }

            public function addQuestion(Question $question): self
            {
                if (!$this->questions->contains($question)) {
                    $this->questions[] = $question;
                    $question->setUser($this);
                }

                return $this;
            }

            public function removeQuestion(Question $question): self
            {
                if ($this->questions->contains($question)) {
                    $this->questions->removeElement($question);
                    // set the owning side to null (unless already changed)
                    if ($question->getUser() === $this) {
                        $question->setUser(null);
                    }
                }

                return $this;
            }

        }


