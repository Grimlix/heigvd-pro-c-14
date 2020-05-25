<?php


namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

use App\Entity\Answer;
use App\Entity\Question;

class AnswerTest extends TestCase
{

    public function testSetQuestionAndGetQuestion(){
        $user = new User();
        $answer = new Answer();
        $question = new Question($user);
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