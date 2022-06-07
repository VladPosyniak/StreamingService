<?php

namespace App\Service;

use App\Entity\SongLike;
use App\Entity\User;
use App\Repository\SongRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Throwable;

class RecommendationService
{
    private SongRepository $songRepository;
    private LoggerInterface $logger;

    public function __construct(
        SongRepository $songRepository,
        LoggerInterface $logger
    ) {
        $this->songRepository = $songRepository;
        $this->logger = $logger;
    }

    public function getListByGenre(UserInterface $user, int $limit): array
    {
        try {
            $songs = $this->songRepository->findByUserLikedGenres($user->getId(), $limit);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            return [];
        }

        return $songs;
    }

    public function getListByOtherUserLikes(UserInterface $user, int $limit): array
    {
        $likes = $user->getSongLikes();
        $usersWithSimilarLikes = [];
        /** @var SongLike $like */
        foreach ($likes as $like) {
            foreach ($like->getSong()->getSongLikes() as $songLike) {
                $user = $songLike->getFromUser();
                $usersWithSimilarLikes[$user->getId()] = $user;
            }
        }

        $allRecommendedSongs = [];
        /** @var User $user */
        foreach ($usersWithSimilarLikes as $user) {
            foreach ($user->getSongLikes() as $songLike) {
                $allRecommendedSongs[] = $songLike->getSong();
            }
        }

        $sortedRecommendedSongs = [];
        foreach ($allRecommendedSongs as $song) {
            if (isset($sortedRecommendedSongs[$song->getId()])) {
                $sortedRecommendedSongs[$song->getId()]['count']++;
            } else {
                $sortedRecommendedSongs[$song->getId()] = [
                  'count' => 1,
                  'song'  => $song
                ];
            }
        }

        usort($sortedRecommendedSongs, static function ($item1, $item2) {
            return $item1['count'] <=> $item2['count'];
        });

        $recommendedSongs = array_map(static function ($item) {
            return $item['song'];
        }, $sortedRecommendedSongs);

        return array_slice($recommendedSongs, 0, $limit);
    }
}