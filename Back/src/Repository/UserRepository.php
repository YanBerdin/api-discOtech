<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    
    public function findByEmail($email): array
    {
        // Alias 'u' for 'User'
        return $this->createQueryBuilder('u')
            // Where name like <search>
            ->where('u.email = :email')
            ->setParameter('email',$email)
            ->getQuery()
            ->getResult();
    }
  
   public function searchIfUserHasFavorite(Album $album, User $user) {

        return $this->createQueryBuilder('u') // "u" for user
            ->join('u.favorites', 'f') // "f" for favorite
            ->where('f.album = :albumId')
            ->setParameter('albumId', $album->getId())
            ->andWhere('f.user = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getOneOrNullResult();
    }
  

    public function findByUserOrder($order = 'ASC')
    {     
         // Alias 'u' for 'users'

        $select = $this->createQueryBuilder('u');

        if ($order === 'fnameASC') {
            $select->orderBy('u.firstname', 'ASC');
        } elseif ($order === 'fnameDESC') {
            $select->orderBy('u.firstname', 'DESC');
        } elseif ($order === 'lnameASC') {
            $select->orderBy('u.lastname', 'ASC');
        } elseif ($order === 'lname') {
            $select->orderBy('u.lastname', 'DESC');
        } elseif ($order === 'rolesASC') {
            $select->orderBy('u.roles', 'ASC');
        } elseif ($order === 'rolesDESC') {
            $select->orderBy('u.roles', 'DESC');
        }

        return $select->getQuery()->getResult();
    }


//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
