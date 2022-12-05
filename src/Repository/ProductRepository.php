<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    const RECORDS_PER_PAGE = 10;

    private int $count = 0;
    private QueryBuilder $query;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findFilteredQueryBuilder(array $filter = [], $currentPage = 1)
    {
        $qb = $this->createQueryBuilder('product');
        if ($filter) {
            $name = array_key_exists('name', $filter) ? $filter['name'] : '';
            $weigth = array_key_exists('weigth', $filter) ? $filter['weigth'] : '';
            $qb
                ->where('product.name LIKE :name')
                ->andWhere('product.weigth LIKE :weigth')
                ->setParameters([
                    'name' => '%'. $name . '%',
                    'weigth' => '%'. $weigth . '%',
                ])
                ->orderBy('product.id', 'ASC');
            if (array_key_exists('sortName', $filter)) {
                $qb->orderBy('product.name', 'asc');
            } elseif (array_key_exists('sortWeight', $filter)) {
                $qb->orderBy('product.weigth', 'asc');
            }
        }

        $res = $this->paginate($qb, $filter['page']);
        $this->count = $res->count();
        $this->query = $qb;

        return $res;
    }

    public function getQ(): QueryBuilder
    {
        return $this->query;
    }

   public function getCount(): int
   {
       return $this->count;
   }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function paginate($dql, $page = 1): Paginator
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult(self::RECORDS_PER_PAGE * ($page - 1)) // Offset
            ->setMaxResults(self::RECORDS_PER_PAGE); // Limit

        return $paginator;
    }

//    /**
//     * @return Product[] Returns an array of Product objects
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

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
