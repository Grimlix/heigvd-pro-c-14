<?php


namespace App\Controller;

use App\Entity\User;
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

        $question = $this->poll_service->get_current_poll_question($poll_token);

        if(!$question){

            return $this->render('admin/runningPoll.html.twig', [
                'question' => 'no question currently running',
                'nextQuestionUrl' =>  $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setNextQuestion/' . $poll_token,
                'lastQuestionUrl' => $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setLastQuestion/' . $poll_token,
                'nbQuestionAnswered' => $this->poll_statistic_service->get_answered_poll_count($poll_token),
                'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token
            ]);

        }
        else{
            return $this->render('admin/runningPoll.html.twig', [
                'question' => $question,
                'nextQuestionUrl' =>  $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setNextQuestion/' . $poll_token,
                'lastQuestionUrl' => $_SERVER['SYMFONY_WEBSITE_ROOT_URL'] . '/home/setLastQuestion/' . $poll_token,
                'nbQuestionAnswered' => $this->poll_statistic_service->get_answered_poll_count($poll_token),
                'listenerUrl' => $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token
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
        return $this->render('home/home.html.twig');
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


    public function index(){
        return $this->render('poll.html.twig');
    }


}