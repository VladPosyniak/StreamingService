<?php

namespace App\Service;

use App\DTO\LikeSongDto;
use App\Entity\Song;
use App\Entity\SongLike;
use App\Entity\User;
use App\Repository\SongLikeRepository;
use App\Repository\SongRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\User\UserInterface;

class SongService
{
    public const DEFAULT_LAST_SINGLES_LIMIT = 5;
    public const DEFAULT_MOST_LIKED_LIMIT = 5;

    private SongRepository $songRepository;
    private SongLikeRepository $songLikeRepository;
    private EntityManagerInterface $em;

    public function __construct(
        SongRepository $songRepository,
        SongLikeRepository $songLikeRepository,
        EntityManagerInterface $em
    )
    {
        $this->songRepository = $songRepository;
        $this->songLikeRepository = $songLikeRepository;
        $this->em = $em;
    }

    /** @return Song[] */
    public function getLastSingles($limit = self::DEFAULT_LAST_SINGLES_LIMIT): array
    {
        return $this->songRepository->findBy([], ['createdAt' => 'DESC'], $limit);
    }

    /** @return Song[] */
    public function getMostLiked($limit = self::DEFAULT_MOST_LIKED_LIMIT): array
    {
        $mostLikedIds = $this->songLikeRepository->getMostLikedSongIds($limit);
        $songs = [];
        foreach ($mostLikedIds as $id) {
            $songs[] = $this->songRepository->findOneBy(['id' => $id]);
        }
        return $songs;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function likeSong(UserInterface $user, int $songId): LikeSongDto
    {
        $song = $this->songRepository->find($songId);
        if ($song === null) {
            throw new \Exception('Unknown song');
        }
        $like = $this->songLikeRepository->findOneBy([
            'song' => $song,
            'fromUser' => $user
        ]);
        $likeSongDto = new LikeSongDto();

        if ($like === null) {
            $like = new SongLike();
            $like->setSong($song);
            $like->setCreatedAt(new \DateTimeImmutable());
            $like->setFromUser($user);
            $this->songLikeRepository->add($like, true);
            $likeSongDto->setIsLiked(true);
        } else {
            $this->em->remove($like);
            $this->em->flush();
            $likeSongDto->setIsLiked(false);
        }

        return $likeSongDto;
    }
}