<?php


namespace App\Controller;

use App\Service\Poll_service;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Admin_controller extends AbstractController
{
    private $poll_service;

    public function __construct(Poll_service $poll_service)
    {
        $this->poll_service = $poll_service;
    }

    public function index(){
        return $this->render('admin/index.html.twig');
    }

    public function create_poll()
    {
       // $ = random_int(1, 100);
        return $this->poll_service->create_poll();
    /*    return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );*/
    }


}