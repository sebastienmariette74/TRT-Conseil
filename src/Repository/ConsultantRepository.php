<?php

namespace App\Repository;

use App\Entity\Consultant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultant>
 *
 * @method Consultant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultant[]    findAll()
 * @method Consultant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultant::class);
    }

    public function add(Consultant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Consultant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
