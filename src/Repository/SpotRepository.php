<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Spot;
use App\Entity\User;
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

    public function getCategoryMainSpots(Category $category)
    {
        return $this->published($this->main($this->category($category)))->getQuery()->getResult();
    }

    public function getTopRated(int $num = 4)
    {
        return $this->published($this->topRated($num))->getQuery()->getResult();
    }

    public function getRandom(int $num = 6)
    {
        return $this->published($this->random($num))->getQuery()->getResult();
    }

    public function getCategoryTopRated(Category $category, int $num = 4)
    {
        return $this->published($this->topRated($num, $this->category($category)))->getQuery()->getResult();
    }

    public function getMostVisitedUserWas(User $user, int $num = 6)
    {
        return $this->published($this->mostVisited($num, $this->userWas($user)))->getQuery()->getResult();
    }

    public function getMostVisitedUserWill(User $user, int $num = 6)
    {
        return $this->published($this->mostVisited($num, $this->userWill($user)))->getQuery()->getResult();
    }

    public function getMostVisited(int $num = 6)
    {
        return $this->published($this->mostVisited($num))->getQuery()->getResult();
    }

    public function getCategoryMostVisited(Category $category, int $num = 6)
    {
        return $this->published($this->mostVisited($num, $this->category($category)))->getQuery()->getResult();
    }

    public function getPublishedCategorySpots(Category $category)
    {
        return $this->published($this->category($category))->getQuery()->getResult();
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

    private function category(Category $category, QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)
            ->leftJoin('s.categories', 'c')
            ->andWhere('c.id IN (:category)')
            ->setParameter('category', $category)
            ->groupBy('s');
    }

    private function userWas(User $user, QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)
            ->andWhere('s.id IN (:spots)')
            ->setParameter('spots', $user->getSpotsUserWas());
    }

    private function userWill(User $user, QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)
            ->andWhere('s.id IN (:spots)')
            ->setParameter('spots', $user->getSpotsUserWill());
    }

    private function random(int $num = 6, QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)
            ->orderBy('RAND()')
            ->setMaxResults($num);
    }

    private function main(QueryBuilder $builder = null)
    {
        return $this->getOrCreateQueryBuilder($builder)->andWhere('s.main = 1');
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

    public function paginateLatestPublishedUserWas(User $user)
    {
        return $this->published($this->latest($this->userWas($user)));
    }

    public function paginateLatestPublishedUserWill(User $user)
    {
        return $this->published($this->latest($this->userWill($user)));
    }

    public function paginateCategoryLatestPublished(Category $category)
    {
        return $this->published($this->latest($this->category($category)));
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
