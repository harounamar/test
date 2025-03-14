<?php

namespace App\Repository;

use App\Entity\Production;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Production>
 */
class ProductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Production::class);
    }

    /**
     * Obtenir les statistiques de production par type
     * @return array
     */
    public function getProductionStatsByType(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.type, SUM(p.quantiteProd) as total_quantity')
            ->groupBy('p.type')
            ->orderBy('total_quantity', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
