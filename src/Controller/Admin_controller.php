<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\TokenType;
use App\Service\Poll_service;
use App\Service\Poll_statistic_service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use App\Entity\Poll;

class Admin_controller extends EasyAdminController
{
    private $poll_service;
    private $poll_statistic_service;
    private $security;

    public function __construct(Poll_service $poll_service, Security $security, Poll_statistic_service $poll_statistic_service ){
        $this->poll_service = $poll_service;
        $this->security = $security;
        $this->poll_statistic_service = $poll_statistic_service;
    }


    public function run_poll($poll_token){

        $currentQuestion = $this->poll_service->get_current_poll_question($poll_token);

        if(!$currentQuestion){

            $questions = $this->poll_service->get_current_poll_questions($poll_token);
            $answers=array();
            if (is_array($questions) || is_object($questions)){
                foreach($questions as $q){
                    $temp = $this->poll_service->get_current_question_answers($q);
                    array_push($answers,$temp);
                }
            }else{
                return $this->render('admin/runningPoll.html.twig', [
                    'question' => 'You have no question in your poll.',
                    'nextQuestionUrl' =>  $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setNextQuestion/' . $poll_token,
                    'lastQuestionUrl' => $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setLastQuestion/' . $poll_token,
                    'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token,
                    'statsOn' => false
                ]);
            }

            $statistics=array();
            foreach($answers as $answer){
                $temp = $this->poll_service->get_answer_stats($answer);
                array_push($statistics,$temp);
            }

            if($this->poll_service->isPollFinished($poll_token)){
                return $this->render('admin/pollFinished.html.twig', [
                    'question' => 'no question currently running',
                    'nextQuestionUrl' =>  $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setNextQuestion/' . $poll_token,
                    'lastQuestionUrl' => $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setLastQuestion/' . $poll_token,
                    'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token,
                    'answers' => $answers,
                    'questions' => $questions,
                    'statistics' => $statistics
                ]);
            }

            return $this->render('admin/runningPoll.html.twig', [
                'question' => 'no question currently running',
                'nextQuestionUrl' =>  $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setNextQuestion/' . $poll_token,
                'lastQuestionUrl' => $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setLastQuestion/' . $poll_token,
                'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token,
                'statsOn' => false
            ]);


        }
        else{
            $currentQuestionAnswers = $this->poll_service->get_current_question_answers($currentQuestion);
            $currentQuestionStatistics = array();
            foreach($currentQuestionAnswers as $answer) {
                $temp = $this->poll_service->get_answer_stats($answer);
                array_push($currentQuestionStatistics, $temp);
            }

            return $this->render('admin/runningPoll.html.twig', [
                'question' => $currentQuestion,
                'nextQuestionUrl' =>  $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setNextQuestion/' . $poll_token,
                'lastQuestionUrl' => $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setLastQuestion/' . $poll_token,
                'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token,
                'currentAnswers' => $currentQuestionAnswers,
                'currentStatistics' => $currentQuestionStatistics,
                'statsOn' => true
            ]);
        }
    }
    public function set_next_question($poll_token){
        $this->poll_service->set_next_question($poll_token);
        $this->poll_service->update_poll_clients($poll_token);
        return new Response('set next question');
    }

    public function set_last_question($poll_token){
        $this->poll_service->set_last_question($poll_token);
        $this->poll_service->update_poll_clients($poll_token);
        return new Response('set last question');
    }


    // Override of the method in EasyAdminController. Allowing us to show only current User's database
    public function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null){

        $response =  parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
        if($entityClass == Poll::class){
            $user = $this->security->getUser();
            $response->andWhere('entity.user = :userId')->setParameter('userId', $user);
        }else if($entityClass == User::class){
            $user = $this->security->getUser();
            $response->andWhere('entity.id = :userId')->setParameter('userId', $user);
        }
        return $response;
    }


    // fonction page home ici pour l'instant
    public function home()
    {
        $form = $this->createForm(TokenType::class);
        return $this->render('home/home.html.twig', [
            'tokenForm' => $form->createView()
        ]);
    }

    // Override of the method in EasyAdminController. Allowing us to show only current User's database
    protected function createSearchQueryBuilder($entityClass, $searchQuery, array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null){
        $response =  parent::createSearchQueryBuilder($entityClass, $searchQuery, $searchableFields, $sortField, $sortDirection, $dqlFilter);
        if($entityClass == Poll::class){
            $user = $this->security->getUser();
            $response->andWhere('entity.user = :userId')->setParameter('userId', $user);
        }else if($entityClass == User::class){
            $user = $this->security->getUser();
            $response->andWhere('entity.id = :userId')->setParameter('userId', $user);
        }
        return $response;
    }

    // Creates a new instance of the entity being created. This instance is passed
    // to the form created with the 'createNewForm()' method. Override this method
    // if your entity has a constructor that expects some arguments to be passed
    protected function createNewPollEntity(){
        return new Poll($this->getUser());
    }
}