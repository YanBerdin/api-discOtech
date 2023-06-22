<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Func;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Album>
 *
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function add(Album $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Album $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find Album by Search
     *
     * @param string $search
     * @return Album[]
     */
    public function findBySearch($search): array
    {
        // Alias 'a' for 'Album'
        //dd($search);
        return $this->createQueryBuilder('a')
            // Where name like <search>
            ->andWhere('a.name LIKE :search')
            ->setParameter('search', '%' .$search. '%')
            ->orderBy("a.name", "ASC")
            ->getQuery()
            ->getResult();

    }

    public function findByAlbumOrder($order = 'ASC')
    {     
        
        $select = $this->createQueryBuilder('a');

        if ($order === 'nameASC') {
            $select->orderBy('a.name', 'ASC');
        } elseif ($order === 'nameDESC') {
            $select->orderBy('a.name', 'DESC');
        } elseif ($order === 'relDateASC') {
            $select->orderBy('a.releaseDate', 'ASC');
        } elseif ($order === 'relDateDESC') {
            $select->orderBy('a.releaseDate', 'DESC');
        } elseif ($order === 'creatAtASC') {
            $select->orderBy('a.createdAt', 'ASC');
        } elseif ($order === 'creatAtDESC') {
            $select->orderBy('a.createdAt', 'DESC');
        }

        return $select->getQuery()->getResult();
    }

    /**
     * Return $limit x Albums randomly
     *
     * @param int $limit
     * @return void
     */
    public function displayRandomAlbums($limit)
    {
        $rsm = new ResultSetMapping();

        $em = $this->getEntityManager();

        $query = $em->createNativeQuery('SELECT * FROM `album` ORDER BY RAND() LIMIT '. $limit , $rsm);
    
        $result = $query->getResult();

        return $result;
    }



    // /**
    // * @return Album[] Returns an array of Album objects
    // */
    // public function findByExampleField($value): array
    // {
    //     return $this->createQueryBuilder('a')
    //         ->andWhere('a.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('a.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

//    public function findOneBySomeField($value): ?Album
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
