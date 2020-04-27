<?php

namespace App\Tests;


use App\Entity\Poll;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PollTest extends WebTestCase
{
    #################################################################
    ## LANCER REGISTER TEST EN PREMIER AFIN QUE JEANTEST SOIT CREE ##
    #################################################################

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

    public function testPollIsCreated(){
        $client = static::createClient();

        $crawler = $client->request('GET','/login');

        $form = $crawler->selectButton('Log in')->form([
            '_username' => 'JeanTest',
            '_password' => '123',
        ]);


        $crawler = $client->submit($form);
        $crawler = $client->followRedirect(true);

        $crawler = $client->request('GET','/admin/?entity=Poll');
        //Just to make sure we're on the right page
        //$this->assertSelectorTextContains('html body','Pass token');


        $addPoll = $crawler
            ->filter('a:contains("Add Poll")')
            ->eq(0) //select first link of the list
            ->link();

        $crawler = $client->click($addPoll);

        //Just to make sure we're on the right page
        //$this->assertSelectorTextContains('html body','Create Poll');

        $createPollForm = $crawler->selectButton('Save changes')->form([
            'poll[name]' => 'JeanFirstPoll',
            'poll[passToken]' => 'JeanCode',
        ]);

        $crawler = $client->submit($createPollForm);
        $crawler = $client->followRedirect(true);

        $this->assertSelectorTextContains('html body','JeanFirstPoll');
        $this->assertSelectorTextContains('html body', 'JeanCode');

    }

}