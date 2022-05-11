<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method User[]    findUserByNsc(string $nsc)
 */
class MynewRepository extends ServiceEntityRepository
{
    
    public function findUserByNsc($nsc){
    return $this->createQueryBuilder('user')
    ->where('user.username LIKE :nsc')
    ->setParameter('nsc', '%'.$nsc.'%')
    ->getQuery()
    ->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */





    
    /*
   public function findUserByNsc($nsc){
    return $this->createQueryBuilder('user')
    ->where('user.username LIKE :nsc')
    ->setParameter('nsc', '%'.$nsc.'%')
    ->getQuery()
    ->getResult();
    }
    */
    
    
}