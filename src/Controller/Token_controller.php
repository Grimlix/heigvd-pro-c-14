<?php

namespace App\Controller;

use App\Form\TokenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Token_controller extends AbstractController
{
    public function index()
    {
        // Creating a form using the TokenType Form class
        $form = $this->createForm(TokenType::class);

        return $this->render('admin/token.html.twig', [
            'tokenForm' => $form->createView()
        ]);
    }
}