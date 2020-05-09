<?php


namespace App\Controller;

use App\Entity\Poll;
use App\Form\TokenType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class Poll_controller extends AbstractController
{
    public function validateToken(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(TokenType::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get access to Poll entity
            $repository = $em->getRepository(Poll::class);
            $token = $form->getData();
            // Search a matching poll
            $poll = $repository->findOneBy(['passToken' => $token]);

            dump($token["token"]);

            // The poll exists
            if ($poll != null) {
                #return $this->render('user/waitingPoll.html.twig');
                #, [
                 #   'pollID' => $poll->getId(),
                  #  'pollName' => $poll->getName(),
                   # 'token' => $poll->getPassToken(),
                    #'userID' => $poll->getUser()->getId(),
                #]);

                return $this->redirectToRoute('app_user_getPoll', ['poll_token' => $token["token"]]);
            } else { // The poll doesn't exist
                return $this->render('admin/poll_inexistent.html.twig');
            }
        }
        // Default : acces to /poll redirects to /
        return $this->redirectToRoute('app_user_index');
    }
}