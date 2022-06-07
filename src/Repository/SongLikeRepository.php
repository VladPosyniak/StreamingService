<?php

namespace App\Repository;

use App\Entity\SongLike;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<SongLike>
 *
 * @method SongLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongLike[]    findAll()
 * @method SongLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongLike::class);
    }


    public function getMostLikedSongIds(int $limit): array
    {
        $connection = $this->getEntityManager()->getConnection();
        $sql = 'SELECT song_id, COUNT(song_id) cnt FROM song_like GROUP BY song_id ORDER BY cnt DESC LIMIT :limit';

        return $connection->prepare($sql)->executeQuery(['limit' => $limit])->fetchFirstColumn();
    }

    /** @return SongLike[] */
    public function getByUser(UserInterface $user): array
    {
        return $this->findBy(['fromUser' => $user]);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SongLike $entity, bool $flush = true): void
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
    public function remove(SongLike $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return SongLike[] Returns an array of SongLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SongLike
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
