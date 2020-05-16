<?php


namespace App\Service;


use App\Entity\Answer;
use App\Entity\PollStatistic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;

class Poll_statistic_service
{
    private $entity_manager;
    private $publisher;
    private $bus;

    public function __construct(EntityManagerInterface $entity_manager, PublisherInterface $publisher, MessageBusInterface $bus){
        $this->entity_manager = $entity_manager;
        $this->publisher = $publisher;
        $this->bus = $bus;
    }

    public function get_answered_poll_count($answerID)
    {
        $poll_statistic = $this->entity_manager
            ->getRepository(PollStatistic::class)
            ->find(1);
        if (!$poll_statistic) {
          $this->create_answer_statistic($answerID);
            $poll_statistic = $this->entity_manager
                ->getRepository(PollStatistic::class)
                ->find(1);
        }
        return $poll_statistic->getCount();
    }

    public function increment_answer_count($answerID)
    {
        $poll_statistic = $this->entity_manager
            ->getRepository(PollStatistic::class)
            ->findOneBy(['answer_id' => $answerID]);

        if (!$poll_statistic) {
            $this->create_answer_statistic($answerID);
            $poll_statistic = $this->entity_manager
                ->getRepository(PollStatistic::class)
                ->findOneBy(['answer_id' => $answerID]);
        }
        $poll_statistic->setCount($poll_statistic->getCount() + 1);
        $this->entity_manager->flush();

    }


    public function create_question_statistics($question){
        $ans = $this->entity_manager
            ->getRepository(Answer::class )
            ->findBy(['question' => $question]);
        foreach($ans as $a){
            $this->create_answer_statistic($a);
        }
    }

    private function create_answer_statistic($answerID){
        $poll_statistic = new PollStatistic($answerID);
        $poll_statistic->setCount(0);
        $this->entity_manager->persist($poll_statistic);
        $this->entity_manager->flush();
    }



    public function update_poll_statistic($poll_token){
        $update = new Update(
            $_ENV['SYMFONY_WEBSITE_ROOT_URL'] . '/home/runPoll/' . $poll_token,
            json_encode(['action' => 'reload'])
        );
        $this->bus->dispatch($update);
    }

}