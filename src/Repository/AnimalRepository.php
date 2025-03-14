<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * Recherche d'animaux par nom partiel
     * @param string $term
     * @return Animal[]
     */
    public function findByName(string $term): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
