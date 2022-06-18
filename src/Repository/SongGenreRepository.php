<?php

namespace App\Repository;

use App\Entity\SongGenre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SongGenre>
 *
 * @method SongGenre|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongGenre|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongGenre[]    findAll()
 * @method SongGenre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongGenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongGenre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SongGenre $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(SongGenre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
