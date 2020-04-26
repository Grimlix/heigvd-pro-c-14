<?php


namespace App\Tests;

use PHPUnit\Framework\TestCase;

use App\Entity\Answer;
use App\Entity\Question;

class AnswerTest extends TestCase
{

    public function testSetQuestionAndGetQuestion(){
        $answer = new Answer();
        $question = new Question();
        $answer->setQuestion($question);
        $this->assertEquals($question, $answer->getQuestion());
    }

    public function testSetAnswerTextAndWetAnswerText(){
        $answer = new Answer();
        $string = "Pamplemousse";
        $answer->setAnswerText($string);
        $this->assertEquals($string, $answer->getAnswerText());
    }


}