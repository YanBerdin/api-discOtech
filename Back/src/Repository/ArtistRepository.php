<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artist>
 *
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function add(Artist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Artist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByArtistOrder($order = 'ASC')
    {     
        // Alias 'a' for 'Artist'
        $select = $this->createQueryBuilder('a');

        if ($order === 'fullnASC') {
            $select->orderBy('a.fullname', 'ASC');
        } elseif ($order === 'fullnDESC') {
            $select->orderBy('a.fullname', 'DESC');
        }

        return $select->getQuery()->getResult();
    }

    /**
     * Find Artist by Search
     *
     * @param string $search
     * @return Artist[]
     */
    public function findBySearch($search): array
    {
        // Alias 'a' for 'Artist'
        //dd($search);
        return $this->createQueryBuilder('a')
            // Where name like <search>
            ->andWhere('a.fullname LIKE :search')
            ->setParameter('search', '%' .$search. '%')
            ->orderBy("a.fullname", "ASC")
            ->getQuery()
            ->getResult();

    }


//    /**
//     * @return Artist[] Returns an array of Artist objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Artist
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
