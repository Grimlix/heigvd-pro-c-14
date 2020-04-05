<?php


namespace App\Service;

class Random_number_generator_service
{
    public function get_random_number($min, $max)
    {
        return  random_int($min, $max);
    }


}