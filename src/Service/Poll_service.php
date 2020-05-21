<?php

namespace App\Service;

use App\Entity\Poll;
use App\Entity\PollStatistic;
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

    public function __construct(EntityManagerInterface $entity_manager, PublisherInterface $publisher, MessageBusInterface $bus)
    {
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
        } else {
            $question = $this->entity_manager
                ->getRepository(Question::class)
                ->findOneBy([
                    'poll' => $poll->getId(),
                    'open' => true,
                    'close' => false
                ]);
            if (!$question) {
                return null;
            } else {
                return $question;
            }
        }
    }

    public function get_current_question_answers($questionID)
    {
        $answers = $this->entity_manager
            ->getRepository(Answer::class)
            ->findBy([
                'question' => $questionID
            ]);
        return $answers;
    }

    public function get_current_poll_questions($poll_token)
    {
        $poll = $this->entity_manager
            ->getRepository(Poll::class)
            ->findOneBy(['passToken' => $poll_token]);
        if (!$poll) {
            return null;
        } else {
            $questions = $this->entity_manager
                ->getRepository(Question::class)
                ->findBy([
                    'poll' => $poll->getId(),
                ]);
            if (!$questions) {
                return null;
            } else {
                return $questions;
            }
        }
    }

    public function get_current_poll_answers($question_id)
    {
        return $this->entity_manager
            ->getRepository(Answer::class)
            ->findBy(['question' => $question_id]);
    }

    public function update_poll_clients($poll_token)
    {
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

    public function get_answer_stats($answerID)
    {
        return $this->entity_manager
            ->getRepository(PollStatistic::class)
            ->findBy(['answer_id' => $answerID]);
    }

    public function set_next_question($poll_token)
    {
        $current_question =
            $this->entity_manager
                ->getRepository(Question::class)
                ->findOneBy([
                    'poll' => $this->entity_manager->getRepository(Poll::class)->findOneBy(['passToken' => $poll_token])->getId(),
                    'open' => true,
                    'close' => false
                ]);
        if ($current_question) {
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
        if ($next_question) {
//            $this->create_question_statistics($next_question);
            $next_question->setOpen(1);
            $this->entity_manager->flush();
        }
    }

    public function set_last_question($poll_token)
    {
        $next_question =
            $this->entity_manager
                ->getRepository(Question::class)
                ->findOneBy([
                    'poll' => $this->entity_manager->getRepository(Poll::class)->findOneBy(['passToken' => $poll_token])->getId(),
                    'open' => true,
                    'close' => true
                ]);
        if ($next_question) {
            $next_question->setClose(0);
            $this->entity_manager->flush();
        }
    }

    public function getPoll($poll_token)
    {
        $poll = $this->entity_manager
            ->getRepository(Poll::class)
            ->findOneBy(['passToken' => $poll_token]);
        return $poll;
    }

    public function isPollFinished($poll_token)
    {
        $questions1 = $this->entity_manager
            ->getRepository(Question::class)
            ->findBy([
                'poll' => $this->entity_manager->getRepository(Poll::class)->findOneBy(['passToken' => $poll_token])->getId(),
                'open' => false,
                'close' => false
            ]);

        $returnVal = true;

        if ($questions1) {
            $returnVal = false;
        }
        return $returnVal;
    }
}