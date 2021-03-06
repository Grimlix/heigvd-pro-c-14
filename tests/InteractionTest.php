<?php


namespace App\Tests;

use App\Entity\Poll;
use App\Entity\Question;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InteractionTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    // On test toute la partie de runningPoll au niveau des questions et de l'affichage admin
    public function testConnection(){
        $this->testStartPoll();
        $this->testEnterPollClient();
        $this->testNextQuestion1();
        $this->testNextQuestion1NoAnswerClient();
        $this->testNextQuestion2();
        $this->testEndPoll();
    }

    private function testEnterPollClient(){
        $client = static::createClient();
        //get the poll
        $crawler = $client->request('GET','/getPoll/JeanCode');
        $this->assertSelectorTextContains('html body','Waiting for the administrator to start the poll..');
    }

    private function testNextQuestion1NoAnswerClient(){
        $client = static::createClient();
        //submit next question
        $crawler = $client->request('GET','/getPoll/JeanCode');
        $this->assertSelectorTextContains('html body','Error, question without any answer');
    }

    private function testStartPoll(){
        $client = static::createClient();

        $question1 = $this->entityManager
            ->getRepository(Question::class)
            ->find(1);

        $question2 = $this->entityManager
            ->getRepository(Question::class)
            ->find(2);

        //run the poll
        $crawler = $client->request('GET','/runPoll/JeanCode');
//        $this->assertSelectorTextContains('html body','no question currently running');

        //check les questions ouverte/fermée
        $this->assertSame(false, $question1->getOpen());
        $this->assertSame(false, $question1->getClose());
        $this->assertSame(false, $question2->getOpen());
        $this->assertSame(false, $question2->getClose());
    }

    private function testNextQuestion1(){

        $client = static::createClient();

        $repository = $this->entityManager->getRepository(Question::class);

        //submit next question
        $crawler = $client->request('GET','/home/setNextQuestion/JeanCode');
        $crawler = $client->request('GET','/runPoll/JeanCode');

        $repository->clear();

        $question1 = $this->entityManager
            ->getRepository(Question::class)
            ->find(1);

        $question2 = $this->entityManager
            ->getRepository(Question::class)
            ->find(2);


        //check les questions ouverte/fermée
        $this->assertSame(true, $question1->getOpen());
        $this->assertSame(false, $question1->getClose());
        $this->assertSame(false, $question2->getOpen());
        $this->assertSame(false, $question2->getClose());
    }

    private function testNextQuestion2(){
        $client = static::createClient();

        $repository = $this->entityManager->getRepository(Question::class);


        //submit next question
        $crawler = $client->request('GET','/home/setNextQuestion/JeanCode');
        $crawler = $client->request('GET','/runPoll/JeanCode');

        $repository->clear();

        $question1 = $this->entityManager
            ->getRepository(Question::class)
            ->find(1);

        $question2 = $this->entityManager
            ->getRepository(Question::class)
            ->find(2);

        //check les questions ouverte/fermée
        $this->assertSame(true, $question1->getOpen());
        $this->assertSame(true, $question1->getClose());
        $this->assertSame(true, $question2->getOpen());
        $this->assertSame(false, $question2->getClose());
    }

    private function testEndPoll(){
        $client = static::createClient();

        $repository = $this->entityManager->getRepository(Question::class);

        //submit next question
        $crawler = $client->request('GET','/home/setNextQuestion/JeanCode');
        $crawler = $client->request('GET','/runPoll/JeanCode');


        $repository->clear();

        $question1 = $this->entityManager
            ->getRepository(Question::class)
            ->find(1);

        $question2 = $this->entityManager
            ->getRepository(Question::class)
            ->find(2);


        //check les questions ouverte/fermée
        $this->assertSame(true, $question1->getOpen());
        $this->assertSame(true, $question1->getClose());
        $this->assertSame(true, $question2->getOpen());
        $this->assertSame(true, $question2->getClose());
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

}