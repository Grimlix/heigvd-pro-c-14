<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Service\Random_number_generator_service;

class Demo_controller extends AbstractController
{
    private $random_nb_generator_service;

    public function __construct(Random_number_generator_service $random_nb_generator_service)
    {
        $this->random_nb_generator_service = $random_nb_generator_service;
    }

    public function get_template(){
        $number = random_int(1000, 2000);
        $number_2 = random_int(1000, 2000);
        return $this->render('demo/number.html.twig', [
            'number' => $number,
            'number2' => $number_2
        ]);
    }
    public function get_http_response()
    {
        $number = random_int(2000, 3000);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /*public function new(Random_number_generator_service $random_nb_generator_service){
        $this->random_nb_generator_service = $random_nb_generator_service;
    }*/

    public function get_random_number(){
        $number = $this->random_nb_generator_service->get_random_number(1,10);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

}