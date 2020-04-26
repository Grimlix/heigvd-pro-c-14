<?php


namespace App\Tests;


use App\Entity\Question;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    public function testSetTextAndGetText(){
        $question = new Question();
        $text = "Hello World!";
        $question->setText($text);
        $this->assertEquals($text, $question->getText());
    }

}