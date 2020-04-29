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
        //Just to make sure we're on the right page
      //  $this->assertSelectorTextContains('html body','Text');
      //  $this->assertSelectorTextContains('html body','Poll');
      //  $this->assertSelectorTextContains('html body','Tags');
      //  $this->assertSelectorTextContains('html body','Answer');
      //  $this->assertSelectorTextContains('html body','Add Question');


        $addQuestion = $crawler
            ->filter('a:contains("Add Question")')
            ->eq(0) //select first link of the list
            ->link();

        $crawler = $client->click($addQuestion);

        //Just to make sure we're on the right page
        //$this->assertSelectorTextContains('html body','Create Question');


        $createQuestionForm = $crawler->selectButton('Save changes')->form([
            'question[text]' => 'Q1 : quel est la meilleure matiere de la heig ?',
        ]);


        $crawler = $client->submit($createQuestionForm);
        $crawler = $client->followRedirect(true);

        $this->assertSelectorTextContains('html body','Q1 : quel est la meilleure matiere de la heig ?');
        $this->assertSelectorTextContains('html body','JeanFirstPoll');


    }
}