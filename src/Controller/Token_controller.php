<?php

namespace App\Controller;

use App\Entity\Poll;
use App\Form\TokenType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
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

    public function validate($object,ExecutionContextInterface $context)
    {
        $repository = $this->getDoctrine()->getRepository(Poll::class);
        $token = $context->getObject();
        // Search a matching poll
        $poll = $repository->findOneBy(['passToken' => $token]);
        // The poll exists


        if ($poll == null) {
                $context->buildViolation('This token does not exist (fdp)!')
                    ->atPath('token[token]')
                    ->addViolation()
                ;
        }


    }
}