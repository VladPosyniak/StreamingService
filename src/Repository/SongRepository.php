<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\Genre;
use App\Entity\Song;
use App\Entity\SongGenre;
use App\Entity\SongLike;
use App\Entity\User;
use App\Model\ReleasePageModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Song>
 *
 * @method Song|null find($id, $lockMode = null, $lockVersion = null)
 * @method Song|null findOneBy(array $criteria, array $orderBy = null)
 * @method Song[]    findAll()
 * @method Song[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Song $entity, bool $flush = true): void
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
    public function remove(Song $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Song[] Returns an array of Song objects
     */
    public function findByReleaseModel(ReleasePageModel $model): array
    {
        $query = $this->createQueryBuilder('s')
            ->setMaxResults($model->getLimit());

        if ($model->getGenre() !== null) {
            $query = $query
                ->innerJoin('s.songGenres', 'g')
                ->where('g.id = :genre')
                ->setParameter('genre', $model->getGenre());
        }

        if ($model->getSearchWord() !== null) {
            $query = $query
                ->where('s.name LIKE :songName')
                ->setParameter('songName', '%' . $model->getSearchWord() . '%');
        }

        return $query->getQuery()->getResult();
    }

    public function findByIds(array $ids): array
    {
        return $this->findBy(['id' => $ids], ['FIELD(song_id, )']);
    }

    public function findByGenre(Genre $genre): array
    {
        $query = $this
            ->createQueryBuilder('s')
            ->innerJoin('s.songGenres', 'g', Join::ON, 's.song = g.song')
            ->where('g.genre = :genre')
            ->setParameter('genre', $genre->getId());

        dd($query->getQuery()->getResult());
        return [];
    }

    /**
     * @return Song[] Returns an array of Song objects
     * @throws Exception
     */
    public function findByUserLikedGenres(int $userId, int $limit): array
    {
        $connection = $this->getEntityManager()->getConnection();
        $sql = 'SELECT song.id, song.album_id, song.name, song.path, song.created_at, song.cover FROM song
                INNER JOIN song_genre sg on song.id = sg.song_id
                WHERE genre_id IN (SELECT genre_id FROM song_genre WHERE song_id IN
                (SELECT song_id FROM song_like WHERE from_user_id = :userID) GROUP BY genre_id) LIMIT :limit;';
        $result = $connection->prepare($sql)->executeQuery([
            'userID' => $userId,
            'limit' => $limit
        ])->fetchAllAssociative();

        $songs = [];
        foreach ($result as $item) {
            $songs[] = $this->createEntityFromRawData($item);
        }

        return $songs;
    }


    public function createEntityFromRawData(array $raw): Song
    {
        $song = new Song();
        $song->setId($raw['id']);
        $song->setAlbum($this->getEntityManager()->find(Album::class, $raw['album_id']));
        $song->setName($raw['name']);
        $song->setPath($raw['path']);
        $song->setCreatedAt(new \DateTimeImmutable($raw['created_at']));
        $song->setCover($raw['cover']);
        foreach ($this->getEntityManager()->getRepository(SongGenre::class)->findBy(['song' => $song]) as $songGenre) {
            $song->addSongGenre($songGenre);
        }
        foreach ($this->getEntityManager()->getRepository(SongLike::class)->findBy(['song' => $song]) as $songLike) {
            $song->addSongLike($songLike);
        }

        return $song;
    }


    /*
    public function findOneBySomeField($value): ?Song
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
