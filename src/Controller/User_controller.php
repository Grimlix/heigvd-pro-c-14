<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Poll_statistic_service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\Poll_service;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class User_controller extends EasyAdminController{
    private $passwordEncoder;
    private $poll_service;
    private $publisher;
    private $poll_statistic_service;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, Poll_service $poll_service, PublisherInterface $publisher, Poll_statistic_service $poll_statistic_service)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->poll_service = $poll_service;
        $this->publisher = $publisher;
        $this->poll_statistic_service = $poll_statistic_service;
    }

    //get current state of the poll i.e. current question
    public function get_poll($poll_token){

        $question = $this->poll_service->get_current_poll_question($poll_token);

        if(!$question){
            //poll is not currently running (no open question)
            return $this->render('user/waitingPoll.html.twig', [
                'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token
            ]);
        }
        $answers = $this->poll_service->get_current_poll_answers($question->getId());
        if(!$answers){
            //question without any answer: means the poll is not correctly defined
            return new Response('Error, question without any answer');
        }

        return $this->render('user/poll.html.twig', [
            'question' => $question,
            'answers' => $answers,
            'formUrl' => $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/incrementPollStatistic/' . $poll_token,
            'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/getPoll/' . $poll_token]);

    }
    public function increment_poll_statistic($poll_token, Request $request){
        $answerID = $request->get('answer');

        $this->poll_statistic_service->increment_answer_count($answerID);
        $this->poll_statistic_service->update_poll_statistic($poll_token);
        return new Response('number of questions answered incremented');
    }


    public function persistUserEntity($user)
    {
        // Avec FOSUserBundle, on faisait comme ça :
        // $this->get('fos_user.user_manager')->updateUser($user, false);
        $this->updatePassword($user);
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        // Avec FOSUserBundle, on faisait comme ça :
        //$this->get('fos_user.user_manager')->updateUser($user, false);
        $this->updatePassword($user);
        parent::updateEntity($user);
    }

    public function updatePassword(User $user)
    {
        if (!empty($user->getPlainPassword())) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }
    }



}
