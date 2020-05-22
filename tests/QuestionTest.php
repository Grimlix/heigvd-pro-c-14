<?php


namespace App\Tests;


use App\Entity\Question;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionTest extends WebTestCase
{
    public function testSetTextAndGetText(){
        $question = new Question();
        $text = "Hello World!";
        $question->setText($text);
        $this->assertEquals($text, $question->getText());
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

        $crawler = $client->request('GET','/admin/?entity=Question');

        $addQuestion = $crawler
            ->filter('a:contains("Add Question")')
            ->eq(0) //select first link of the list
            ->link();

        $crawler = $client->click($addQuestion);

        $createQuestionForm = $crawler->selectButton('Save changes')->form([
            'question[text]' => 'Q1 : quelle est la meilleure matiere de la heig ?',
        ]);


        $crawler = $client->submit($createQuestionForm);
        $crawler = $client->followRedirect(true);

        $this->assertSelectorTextContains('html body','Q1 : quelle est la meilleure matiere de la heig ?');
        $this->assertSelectorTextContains('html body','JeanFirstPoll');


    }

    public function testPollIsCreatedSameName(){
        $client = static::createClient();

        $crawler = $client->request('GET','/login');

        $form = $crawler->selectButton('Log in')->form([
            '_username' => 'JeanTest',
            '_password' => '123',
        ]);


        $crawler = $client->submit($form);
        $crawler = $client->followRedirect(true);

        $crawler = $client->request('GET','/admin/?entity=Question');

        $addQuestion = $crawler
            ->filter('a:contains("Add Question")')
            ->eq(0) //select first link of the list
            ->link();

        $crawler = $client->click($addQuestion);

        //Just to make sure we're on the right page
        //$this->assertSelectorTextContains('html body','Create Question');


        $createQuestionForm = $crawler->selectButton('Save changes')->form([
            'question[text]' => 'Q2 : quelle est la deuxieme meilleure matiere de la heig ?',
        ]);


        $crawler = $client->submit($createQuestionForm);
        $crawler = $client->followRedirect(true);

        $this->assertSelectorTextContains('html body','Q2 : quelle est la deuxieme meilleure matiere de la heig ?');
        $this->assertSelectorTextContains('html body','JeanFirstPoll');


    }
}