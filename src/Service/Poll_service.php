<?php


namespace App\Service;

use App\Entity\Poll;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class Poll_service
{
    private $entity_manager;

    public function __construct(EntityManagerInterface $entity_manager){
        $this->entity_manager = $entity_manager;
    }

    public function create_poll(): Response
    {
        $poll = new Poll();
        $poll->setName('test');

        $this->entity_manager->persist($poll);
        $this->entity_manager->flush();

        return new Response('Saved new product with id '.$poll->getId());
    }














    /*
    public function delete_poll($id): Response {

        $product = $this->getDoctrine()
            ->getRepository(Poll::class)
            ->find($id);

        $this->entity_manager->remove($product->getId());
        $this->entity_manager->flush();

        return new Response('Deleted product with id ' .$this->getId());
    }
    */

}