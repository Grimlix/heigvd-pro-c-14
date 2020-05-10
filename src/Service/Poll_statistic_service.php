<?php


namespace App\Service;


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

    public function get_answered_poll_count()
    {
        $poll_statistic = $this->entity_manager
            ->getRepository(PollStatistic::class)
            ->find(1);
        if (!$poll_statistic) {
            $this->create_poll_statistic();
            $poll_statistic = $this->entity_manager
                ->getRepository(PollStatistic::class)
                ->find(1);
        }
        return $poll_statistic->getCount();
    }
    public function increment_poll_count()
    {
        $poll_statistic = $this->entity_manager
            ->getRepository(PollStatistic::class)
            ->find(1);
        if (!$poll_statistic) {
            $this->create_poll_statistic();
            $poll_statistic = $this->entity_manager
                ->getRepository(PollStatistic::class)
                ->find(1);
        }
        $poll_statistic->setCount($poll_statistic->getCount() + 1);
        $this->entity_manager->flush();

    }
    private function create_poll_statistic(){
        $poll_statistic = new PollStatistic();
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