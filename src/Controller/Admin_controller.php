<?php


namespace App\Controller;

use App\Service\Poll_service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

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
        $user = $this->security->getUser();
        $response->andWhere('entity.user = :userId')->setParameter('userId', $user);

        return $response;
    }

    // Override of the method in EasyAdminController. Allowing us to show only current User's database
    protected function createSearchQueryBuilder($entityClass, $searchQuery, array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null){
        $response =  parent::createSearchQueryBuilder($entityClass, $searchQuery, $searchableFields, $sortField, $sortDirection, $dqlFilter);
        $user = $this->security->getUser();
        $response->andWhere('entity.user = :userId')->setParameter('userId', $user);

        return $response;
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