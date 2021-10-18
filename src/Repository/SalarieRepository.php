<?php

namespace App\Repository;

use App\Entity\Salarie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salarie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salarie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salarie[]    findAll()
 * @method Salarie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalarieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salarie::class);
    }

    public function getAll(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                    'SELECT s
                        FROM App\Entity\Salarie s
                        ORDER BY s.dateEmbauche DESC'
                );
        return $query->execute();
    }

    /**
    * @return Salarie[] Un tableau des salariés travaillant dans une entreprise.
    */
    public function getSalarieByEntreprise($id)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.entreprise = :val')
            ->setParameter('val', $id)
            ->orderBy('s.dateEmbauche', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Salarie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
