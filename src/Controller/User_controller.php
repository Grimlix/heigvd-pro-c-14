<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class User_controller extends AbstractController
{
    public function getCurrentPoll()
    {
        $number = random_int(100, 1000);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    
    
}
