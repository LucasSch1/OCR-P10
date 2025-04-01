<?php

namespace App\Repository;

use App\Entity\Employe;
use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 */
class ProjetRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }


    public function findProjetsVisibles(Employe $user): array
    {
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.archive = 0');

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $qb->getQuery()->getResult();
        }

        return $qb
            ->join('p.employes', 'e')
            ->andWhere('e = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

    }

    //    /**
    //     * @return Projet[] Returns an array of Projet objects
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

    //    public function findOneBySomeField($value): ?Projet
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
