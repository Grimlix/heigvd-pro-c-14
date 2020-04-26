<?php


namespace App\Tests;


use App\Entity\Poll;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetPollsAndAddPolls(){
        $user = new User();
        $poll = new Poll($user);
        $user->addPoll($poll);
        $this->assertEquals($poll, $user->getPolls()[0]);
    }

    public function testRemovePoll(){
        $user = new User();
        $poll = new Poll($user);
        $user->addPoll($poll);
        $user->removePoll($poll);
        $this->assertEmpty($user->getPolls());
    }




}