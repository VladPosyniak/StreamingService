<?php

namespace App\Controller;

use App\Repository\SongLikeRepository;
use App\Service\SongService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    private SongService $songService;
    private LoggerInterface $logger;
    private SongLikeRepository $songLikeRepository;

    public function __construct(
        SongService $songService,
        LoggerInterface $logger,
        SongLikeRepository $songLikeRepository
    ) {
        $this->songService = $songService;
        $this->logger = $logger;
        $this->songLikeRepository = $songLikeRepository;
    }

    #[Route('song/{songId}/like', name: 'page-like-song', methods: ['POST'])]
    public function like(int $songId): Response
    {
        try {
            $likeSongDto = $this->songService->likeSong($this->getUser(), $songId);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return new JsonResponse([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
        return new JsonResponse([
            'status' => true,
            'isLiked'=> $likeSongDto->isLiked()
        ]);
    }

    #[Route('likes', name: 'page-likes')]
    public function likes(): Response
    {
        $likes = $this->songLikeRepository->findBy([
            'fromUser' => $this->getUser()
        ], ['createdAt' => 'DESC']);
        return $this->render('likes.html.twig', [
            'likes' => $likes
        ]);
    }
}
