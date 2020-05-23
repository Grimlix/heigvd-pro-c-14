<?php


namespace App\Tests;


use App\Entity\Answer;
use App\Entity\Poll;
use App\Entity\Question;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{

    public function testGetPollsAndAddPolls(){
        $user = new User();
        $poll = new Poll($user);

        $question1 = new Question();
        $question1->setPoll($poll);
        $question1->setText("Question1");


        $poll2 = new Poll($user);
        $question2 = new Question();
        $question2->setPoll($poll2);

        $poll->addQuestion($question1);
        $poll2->addQuestion($question2);

        $user->addPoll($poll);
        $user->addPoll($poll2);

        $this->assertEquals($poll, $user->getPolls()[0]);
        $this->assertEquals($poll2, $user->getPolls()[1]);
        $this->assertNotEquals($poll, $user->getPolls()[1]);
        $this->assertNotEquals($poll2, $user->getPolls()[0]);
    }

    public function testRemovePoll(){
        $user = new User();
        $poll = new Poll($user);
        $user->addPoll($poll);
        $user->removePoll($poll);
        $this->assertEmpty($user->getPolls());
    }

    public function testGetAndSetPlainPassword(){
        $user = new User();
        $user->setPlainPassword("hello");
        $this->assertEquals("hello", $user->getPlainPassword());
    }




}