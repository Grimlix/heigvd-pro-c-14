<?php


namespace App\Controller;


use App\Entity\Answer;
use App\Entity\Question;
use App\Form\questionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends AbstractController
{
    public function new(Request $request){
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        return $this->render('admin\question.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}