<?php


namespace App\Controller;

use App\Entity\Poll;
use App\Form\TokenType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class Poll_controller extends AbstractController
{

    public function validateToken(Request $request)
    {
        $form = $this->createForm(TokenType::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = $form->getData();
            return $this->redirectToRoute('app_user_getPoll', ['poll_token' => $token["token"]]);
        }
        // Default : renders home page with the form errors
        return $this->render('home/home.html.twig', [
            'tokenForm' => $form->createView(),
        ]);
    }


    /**
     * @Route(path = "/run", name = "Run")
     * This function is with the Run button in the EasyAdmin page. It allow us to
     * start a poll.
     */
    public function runAction(Request $request, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Poll::class);
        $id = $request->query->get('id');
        $poll = $repository->find($id);
        $token = $poll->getPassToken();
        return $this->redirectToRoute('app_admin_runPoll', ['poll_token' => $token]);
    }

}