<?php

namespace App\Tests;


use App\Entity\Poll;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class PollTest extends TestCase
{
    public function testConstructorAndGetUser(){
        $user = new User();
        $poll = new Poll($user);
        $this->assertEquals($user, $poll->getUser());
    }
    public function testSetNameAndGetName(){
        $user = new User();
        $poll =  new Poll($user);
        $name = "Poll1";
        $poll->setName($name);
        $this->assertEquals($name, $poll->getName());
    }

    public function testSetPassTokenAndGetPassToken(){
        $user = new User();
        $poll =  new Poll($user);
        $passToken = "abcd";
        $poll->setPassToken($passToken);
        $this->assertEquals($passToken, $poll->getPassToken());
    }

}