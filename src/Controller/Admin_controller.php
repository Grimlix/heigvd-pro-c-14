<?php


namespace App\Controller;

use App\Service\Poll_service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin_controller extends AbstractController
{
    private $poll_service;

    public function __construct(Poll_service $poll_service){
        $this->poll_service = $poll_service;
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