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

            // The poll exists
            if ($poll != null) {
                return $this->redirectToRoute('app_user_getPoll', ['poll_token' => $token["token"]]);
            } else { // The poll doesn't exist
                return $this->render('admin/poll_inexistent.html.twig');
            }
        }
        // Default : acces to /poll redirects to /
        return $this->redirectToRoute('app_user_index');
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