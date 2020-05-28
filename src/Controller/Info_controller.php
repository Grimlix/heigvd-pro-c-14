<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Info_controller extends AbstractController
{
     /**
      * @Route("/info")
      */
    public function index()
    {
        return $this->render('info/info.html.twig');
    }
}