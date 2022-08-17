<?php

namespace App\Repository;

use App\Entity\PostData;
use App\Entity\SocialNetwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostData>
 *
 * @method PostData|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostData|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostData[]    findAll()
 * @method PostData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostData::class);
    }

    public function add(PostData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PostData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return PostData[] Returns an array of PostData objects
    */
    public function findByYearAndNetwork($value, SocialNetwork $network): array
    {
        $year = intval($value);
        $previousYear = $year - 1;
        $nextYear = $year + 1;

        //$previousYearDate = \DateTime::createFromFormat("Y", $previousYear);
        //$nextYearDate = \DateTime::createFromFormat("Y", $nextYear);

        return $this->createQueryBuilder('pdat')
            ->leftJoin('pdat.post', 'p')
            ->andWhere('p.publishDate > :prev')
            ->andWhere('p.publishDate < :next')
            ->andWhere('pdat.network = :network')
            ->setParameter('prev', $previousYear."-01-01 00:00:00")
            ->setParameter('next', $nextYear."-01-01 00:00:00")
            ->setParameter('network', $network)
            ->orderBy('pdat.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return PostData[] Returns an array of PostData objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PostData
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
