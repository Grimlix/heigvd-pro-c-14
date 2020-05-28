<?php

namespace App\Repository;

use App\Entity\PollStatistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PollStatistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method PollStatistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method PollStatistic[]    findAll()
 * @method PollStatistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PollStatisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PollStatistic::class);
    }
}
