<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints;

class wrongToken extends Constraint
{
    public $message = "This token does not exist, sadly, better luck next time.";
}