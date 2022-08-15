<?php

namespace App\Repository;

use App\Entity\Spot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Spot>
 *
 * @method Spot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spot[]    findAll()
 * @method Spot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spot::class);
    }

    public function add(Spot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Spot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTopRated(int $num)
    {
        return $this->published($this->topRated($num))->getQuery()->getResult();
    }

    public function getMostVisited(int $num)
    {
        return $this->published($this->mostVisited($num))->getQuery()->getResult();
    }

    public function getPublished()
    {
        return $this->published()->getQuery()->getResult();
    }

    private function latest(QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)
            ->orderBy('s.published_at', 'DESC');
    }

    private function topRated(int $num = 4, QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)
            ->orderBy('s.rating', 'DESC')
            ->setMaxResults($num);
    }

    private function mostVisited(int $num = 6, QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)
            ->select('s')
            ->leftJoin('s.user_was', 'u')
            ->addSelect('COUNT(u.id) as HIDDEN visitors')
            ->orderBy('visitors', 'DESC')
            ->setMaxResults($num)
            ->groupBy('s');
    }

    private function published(QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)->andWhere('s.published_at IS NOT NULL');
    }

    public function paginateLatestPublished()
    {
        return $this->published($this->latest());
    }

//    /**
//     * @return Spot[] Returns an array of Spot objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Spot
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @param QueryBuilder|null $builder
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(?QueryBuilder $builder): QueryBuilder
    {
        return $builder ?? $this->createQueryBuilder('s');
    }
}
