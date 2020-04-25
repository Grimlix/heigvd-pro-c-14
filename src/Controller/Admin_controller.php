<?php


namespace App\Controller;

use App\Service\Poll_service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use App\Entity\Poll;

class Admin_controller extends EasyAdminController
{
    private $poll_service;

    private $security;

    public function __construct(Poll_service $poll_service, Security $security){
        $this->poll_service = $poll_service;
        $this->security = $security;
    }

    // Override of the method in EasyAdminController. Allowing us to show only current User's database
    public function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null){

        $response =  parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
        if($entityClass == Poll::class){
            $user = $this->security->getUser();
            $response->andWhere('entity.user = :userId')->setParameter('userId', $user);
        }
        return $response;
    }

    // Override of the method in EasyAdminController. Allowing us to show only current User's database
    protected function createSearchQueryBuilder($entityClass, $searchQuery, array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null){
        $response =  parent::createSearchQueryBuilder($entityClass, $searchQuery, $searchableFields, $sortField, $sortDirection, $dqlFilter);
        if($entityClass == Poll::class){
            $user = $this->security->getUser();
            $response->andWhere('entity.user = :userId')->setParameter('userId', $user);
        }
        return $response;
    }

    // Creates a new instance of the entity being created. This instance is passed
    // to the form created with the 'createNewForm()' method. Override this method
    // if your entity has a constructor that expects some arguments to be passed
    protected function createNewEntity(){
        //dump($this->entity);
        $entity = new $this->entity['class']($this->getUser());
        return $entity;


    }



    public function index(){
        return $this->render('admin/index.html.twig');
    }

    public function create_poll(){
        return $this->poll_service->create_poll();
    }


    /*
    public function delete_poll($id){
        $this->poll_service->delete_poll($id);
        return $this->render('admin/index.html.twig');
    }
    */

}