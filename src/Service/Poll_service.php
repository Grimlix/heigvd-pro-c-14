<?php


namespace App\Service;

use App\Entity\Poll;
use App\Entity\Question;
use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;

class Poll_service
{
    private $entity_manager;
    private $publisher;
    private $bus;

    public function __construct(EntityManagerInterface $entity_manager, PublisherInterface $publisher, MessageBusInterface $bus){
        $this->entity_manager = $entity_manager;
        $this->publisher = $publisher;
        $this->bus = $bus;
    }


    public function get_current_poll_question($poll_token)
    {
        $poll = $this->entity_manager
            ->getRepository(Poll::class)
            ->findOneBy(['passToken' => $poll_token]);
        if (!$poll) {
            return null;
        }
        else {
            $question = $this->entity_manager
                ->getRepository(Question::class)
                ->findOneBy([
                    'poll' => $poll->getId(),
                    'open' => true,
                    'close' => false
                ]);
            if(!$question){
                return null;
            }
            else{
                return $question;
            }
        }
    }
    public function get_current_poll_answers($question_id)
    {
        return $this->entity_manager
            ->getRepository(Answer::class)
            ->findBy(['question' => $question_id]);

    }
    public function update_poll_clients($poll_token){
        $update = new Update(
            $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/getPoll/' . $poll_token,
            json_encode(['action' => 'reload'])
        );
        $this->bus->dispatch($update);
        $update_admin = new Update(
            $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token,
            json_encode(['action' => 'reload'])
        );
        $this->bus->dispatch($update_admin);
    }

    public function set_next_question($poll_token){
        $current_question =
            $this->entity_manager
                ->getRepository(Question::class)
                ->findOneBy([
                    'poll' => $this->entity_manager->getRepository(Poll::class)->findOneBy(['passToken' => $poll_token])->getId(),
                    'open' => true,
                    'close' => false
                ]);
        if($current_question){
            $current_question->setClose(1);
            $this->entity_manager->flush();
        }
        $next_question =
            $this->entity_manager
                ->getRepository(Question::class)
                ->findOneBy([
                    'poll' => $this->entity_manager->getRepository(Poll::class)->findOneBy(['passToken' => $poll_token])->getId(),
                    'open' => false,
                    'close' => false
                ]);
        if($next_question){
            $next_question->setOpen(1);
            $this->entity_manager->flush();
        }
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